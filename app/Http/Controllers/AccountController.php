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
        if (!empty($searchName) || !empty($searchUsername)) {
            $accountsCollection = $accountsCollection->filter(function ($account) use ($searchName, $searchUsername) {
                $nameMatch = empty($searchName) || stripos($account->full_name, $searchName) !== false;
                $usernameMatch = empty($searchUsername) || stripos($account->username, $searchUsername) !== false;
                return $nameMatch && $usernameMatch;
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

        return view('account.index', compact('paginatedAccounts', 'searchName', 'searchUsername'));
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
        ]);

        try {
            DB::select('CALL spAddAccount(?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['first_name'],
                $validated['middle_name'],
                $validated['last_name'],
                $validated['birth_date'],
                $validated['username'],
                $validated['password'],
                isset($validated['is_active']) ? $validated['is_active'] : false,
                $validated['note'] ?? null,
            ]);

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
        ]);

        try {
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

            return redirect()->route('accounts.index')
                ->with('success', 'Account succesvol bijgewerkt.');
        } catch (\Exception $e) {
            Log::error('Error updating account: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van het account.');
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
