<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class AccountController extends Controller
{
    /**
     * Toon een lijst van alle klanten.
     */
    public function index(Request $request)
    {
        $searchName = $request->input('searchName', '');
        $searchUsername = $request->input('searchUsername', '');
        $searchStatus = $request->input('searchStatus');

        // Call the stored procedure
        try {
            $accounts = DB::select('CALL spGetAllAccounts()') ?? [];
        } catch (\Exception $e) {
            // Log the error and return an empty array
            Log::error('Failed to fetch accounts: ' . $e->getMessage());
            $accounts = [];
        }

        // Convert the result to a collection
        $accountsCollection = collect($accounts);

        // Apply filters if search parameters are provided
        if (!empty($searchName) || !empty($searchUsername) || $searchStatus !== null) {
            $accountsCollection = $accountsCollection->filter(function ($account) use ($searchName, $searchUsername, $searchStatus) {
                $nameMatch = empty($searchName) || stripos($account->full_name, $searchName) !== false;
                $usernameMatch = empty($searchUsername) || stripos($account->username, $searchUsername) !== false;
                $statusMatch = $searchStatus === null || ($searchStatus == "1" && $account->is_active) || ($searchStatus == "0" && !$account->is_active);
                
                return $nameMatch && $usernameMatch && $statusMatch;
            });
        }

        // Paginate the collection
        $currentPage = request('page', 1);
        $perPage = 15; // Number of items per page
        $paginatedAccounts = new LengthAwarePaginator(
            $accountsCollection->forPage($currentPage, $perPage),
            $accountsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('account.index', compact('paginatedAccounts', 'searchName', 'searchUsername', 'searchStatus'));
    }

    /**
     * Toon het formulier om een nieuw account aan te maken.
     */
    public function create()
    {
        return view('account.create');
    }

    /**
     * Sla een nieuw account op.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'is_active' => 'boolean',
            'note' => 'nullable|string',
            // Contact information validation
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            // Address information validation
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
        ]);

        try {
            // Create user account and contact information using stored procedure
            $result = DB::select('CALL spAddAccount(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['first_name'],
                $validated['middle_name'] ?? null,
                $validated['last_name'],
                $validated['birth_date'] ?? null,
                $validated['username'],
                $validated['password'],
                isset($validated['is_active']) ? $validated['is_active'] : false,
                $validated['note'] ?? null,
                $validated['email'] ?? null,
                $validated['mobile'] ?? null,
                $validated['street'] ?? null,
                $validated['house_number'] ?? null,
                $validated['addition'] ?? null,
                $validated['postal_code'] ?? null,
                $validated['city'] ?? null,
            ]);
            
            $userId = $result[0]->user_id;
            
            return redirect()->route('accounts.index')
                ->with('success', 'Account succesvol aangemaakt.');
        } catch (\Exception $e) {
            Log::error('Error creating account: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van het account.');
        }
    }

    /**
     * Toon een specifiek account.
     */
    public function show($id)
    {
        try {
            $account = collect(DB::select('CALL spGetAccountById(?)', [$id]))->first();

            if (!$account) {
                return redirect()->route('accounts.index')
                    ->with('error', 'Account niet gevonden.');
            }

            return view('account.show', compact('account'));
        } catch (\Exception $e) {
            return redirect()->route('accounts.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van het account.');
        }
    }

    /**
     * Toon het formulier om een account te bewerken.
     */
    public function edit($id)
    {
        try {
            $account = collect(DB::select('CALL spGetAccountById(?)', [$id]))->first();

            if (!$account) {
                return redirect()->route('accounts.index')
                    ->with('error', 'Account niet gevonden.');
            }

            return view('account.edit', compact('account'));
        } catch (\Exception $e) {
            return redirect()->route('accounts.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van het account.');
        }
    }

    /**
     * Werk een bestaand account bij.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8',
            'is_active' => 'boolean',
            'note' => 'nullable|string',
            // Contact information validation
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            // Address information validation
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
        ]);

        try {
            // Begin transaction
            DB::beginTransaction();
            
            // Update user account
            DB::select('CALL spUpdateAccount(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $validated['first_name'],
                $validated['middle_name'],
                $validated['last_name'],
                $validated['birth_date'],
                $validated['username'],
                $request->filled('password') ? $validated['password'] : '',
                isset($validated['is_active']) ? $validated['is_active'] : false,
                $validated['note'] ?? null,
            ]);

            // Check if contact exists
            $contactExists = DB::table('contacts')->where('user_id', $id)->exists();
            
            $contactData = [
                'email' => $validated['email'] ?? null,
                'mobile' => $validated['mobile'] ?? null,
                'street' => $validated['street'] ?? null,
                'house_number' => $validated['house_number'] ?? null,
                'addition' => $validated['addition'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
                'city' => $validated['city'] ?? null,
                'updated_at' => now(),
            ];

            if ($contactExists) {
                // Update existing contact
                DB::table('contacts')
                    ->where('user_id', $id)
                    ->update($contactData);
            } else {
                // Create new contact if any contact field is filled
                if ($request->filled('email') || $request->filled('mobile') || 
                    $request->filled('street') || $request->filled('house_number') || 
                    $request->filled('postal_code') || $request->filled('city')) {
                    
                    $contactData['user_id'] = $id;
                    $contactData['created_at'] = now();
                    
                    DB::table('contacts')->insert($contactData);
                }
            }
            
            // Commit transaction
            DB::commit();

            return redirect()->route('accounts.index')
                ->with('success', 'Account succesvol bijgewerkt.');
        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();
            
            Log::error('Error updating account: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van het account: ' . $e->getMessage());
        }
    }

    /**
     * Verwijder een account.
     */
    public function destroy($id)
    {
        try {
            // Check if account exists
            $account = collect(DB::select('CALL spGetAccountById(?)', [$id]))->first();

            if (!$account) {
                return redirect()->route('accounts.index')
                    ->with('error', 'Account niet gevonden.');
            }

            DB::select('CALL spDeleteAccount(?)', [$id]);
            return redirect()->route('accounts.index')
                ->with('success', 'Account is succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Error deleting account: ' . $e->getMessage());
            return redirect()->route('accounts.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van het account.');
        }
    }
}
