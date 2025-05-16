<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

// use App\Models\Person;
// use App\Models\Customer;
// use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class AccountController extends Controller
{
    /**
     * Toon een lijst van alle klanten.
     */
    public function index()
    {
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

        return view('account.index', compact('paginatedAccounts'));
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
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'relation_number' => 'required|string|unique:customers,relation_number',
            'email' => 'required|email|unique:contacts,email',
            'mobile' => 'required|string|max:20', // Changed from nullable to required
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Prepare passport details as JSON
        $passportDetails = null;
        if ($request->filled('passport_number') || $request->filled('passport_expiry')) {
            $passportDetails = json_encode([
                'passport_number' => $request->passport_number,
                'passport_expiry' => $request->passport_expiry,
            ]);
        }

        try {
            DB::select('CALL spAddAccount(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['first_name'],
                $validated['middle_name'],
                $validated['last_name'],
                $validated['birth_date'],
                $passportDetails,
                $validated['relation_number'],
                $validated['email'],
                $validated['mobile'],
                $validated['street'],
                $validated['house_number'],
                $validated['addition'],
                $validated['postal_code'],
                $validated['city'],
                $validated['is_active'] ?? true,
            ]);

            return redirect()->route('account.index')
                ->with('success', 'Account succesvol aangemaakt.');
        } catch (\Exception $e) {
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
                return redirect()->route('account.index')
                    ->with('error', 'Account niet gevonden.');
            }

            return view('account.show', compact('account'));
        } catch (\Exception $e) {
            return redirect()->route('account.index')
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
                return redirect()->route('account.index')
                    ->with('error', 'Account niet gevonden.');
            }

            return view('account.edit', compact('account'));
        } catch (\Exception $e) {
            return redirect()->route('account.index')
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
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date|after:today',
            'relation_number' => 'required|string|unique:customers,relation_number,' . $id,
            'email' => 'required|email|unique:contacts,email,' . $id . ',customer_id',
            'mobile' => 'required|string|max:20',
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'addition' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Prepare passport details with validation
        $passportDetails = null;
        if ($request->filled('passport_number') || $request->filled('passport_expiry')) {
            if (!$request->filled('passport_number') && !$request->filled('passport_expiry')) {
                return back()->withInput()
                    ->withErrors(['passport' => 'Both passport number and expiry date are required when providing passport details.']);
            }
            $passportDetails = json_encode([
                'passport_number' => $request->passport_number,
                'passport_expiry' => $request->passport_expiry,
            ]);
        }

        try {
            DB::select('CALL spUpdateAccount(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $validated['first_name'],
                $validated['middle_name'],
                $validated['last_name'],
                $validated['birth_date'],
                $passportDetails,
                $validated['relation_number'],
                $validated['email'],
                $validated['mobile'],
                $validated['street'],
                $validated['house_number'],
                $validated['addition'],
                $validated['postal_code'],
                $validated['city'],
                $validated['is_active'] ?? true,
            ]);

            return redirect()->route('account.index')
                ->with('success', 'Account succesvol bijgewerkt.');
        } catch (\PDOException $e) {
            Log::error('Database error while updating account: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Database fout bij het bijwerken van het account.');
        } catch (\Exception $e) {
            Log::error('Error while updating account: ' . $e->getMessage());
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
                return redirect()->route('account.index')
                    ->with('error', 'Account niet gevonden.');
            }

            DB::select('CALL spDeleteAccount(?)', [$id]);
            return redirect()->route('account.index')
                ->with('success', 'Account is succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Error deleting account: ' . $e->getMessage());
            return redirect()->route('account.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van het account.');
        }
    }
}
