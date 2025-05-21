<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Toon een lijst van alle facturen.
     */
    public function index(Request $request)
    {
        $searchInvoiceNumber = $request->input('searchInvoiceNumber', '');
        $searchStatus = $request->input('searchStatus', '');

        // Call the stored procedure
        try {
            $invoices = DB::select('CALL spGetAllInvoices()') ?? [];
        } catch (\Exception $e) {
            // Log the error and return an empty array
            Log::error('Failed to fetch invoices: ' . $e->getMessage());
            $invoices = [];
        }

        // Convert the result to a collection
        $invoicesCollection = collect($invoices);

        // Apply filters if search parameters are provided
        if (!empty($searchInvoiceNumber) || !empty($searchStatus)) {
            $invoicesCollection = $invoicesCollection->filter(function ($invoice) use ($searchInvoiceNumber, $searchStatus) {
                $invoiceNumberMatch = empty($searchInvoiceNumber) || stripos($invoice->invoice_number, $searchInvoiceNumber) !== false;
                $statusMatch = empty($searchStatus) || stripos($invoice->status, $searchStatus) !== false;
                return $invoiceNumberMatch && $statusMatch;
            });
        }

        // Paginate the collection
        $currentPage = request('page', 1);
        $perPage = 15; // Number of items per page
        $paginatedInvoices = new LengthAwarePaginator(
            $invoicesCollection->forPage($currentPage, $perPage),
            $invoicesCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('invoices.index', compact('paginatedInvoices', 'searchInvoiceNumber', 'searchStatus'));
    }

    /**
     * Toon het formulier om een nieuwe factuur aan te maken.
     */
    public function create()
    {
        // Get registrations for dropdown
        $registrations = DB::select('SELECT r.id, CONCAT(u.first_name, " ", u.last_name, " - ", p.type) AS description 
                                     FROM registrations r 
                                     JOIN students s ON r.student_id = s.id 
                                     JOIN users u ON s.user_id = u.id 
                                     JOIN packages p ON r.package_id = p.id');
        
        return view('invoices.create', compact('registrations'));
    }

    /**
     * Sla een nieuwe factuur op.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'status' => 'required|string|max:50',
            'amount_excl_vat' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'amount_incl_vat' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'registration_id' => 'required|exists:registrations,id',
            'is_active' => 'boolean',
        ]);

        try {
            DB::select('CALL spAddInvoice(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $validated['invoice_number'],
                $validated['invoice_date'],
                $validated['status'],
                $validated['amount_excl_vat'],
                $validated['vat'],
                $validated['amount_incl_vat'],
                $validated['note'] ?? null,
                $validated['registration_id'],
                isset($validated['is_active']) ? $validated['is_active'] : true,
            ]);

            return redirect()->route('invoices.index')
                ->with('success', 'Factuur succesvol aangemaakt.');
        } catch (\Exception $e) {
            Log::error('Error creating invoice: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van de factuur.');
        }
    }

    /**
     * Toon een specifieke factuur.
     */
    public function show($id)
    {
        try {
            $invoice = collect(DB::select('CALL spGetInvoiceById(?)', [$id]))->first();

            if (!$invoice) {
                return redirect()->route('invoices.index')
                    ->with('error', 'Factuur niet gevonden.');
            }

            return view('invoices.show', compact('invoice'));
        } catch (\Exception $e) {
            Log::error('Error fetching invoice: ' . $e->getMessage());
            return redirect()->route('invoices.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de factuur.');
        }
    }

    /**
     * Toon het formulier om een factuur te bewerken.
     */
    public function edit($id)
    {
        try {
            $invoice = collect(DB::select('CALL spGetInvoiceById(?)', [$id]))->first();

            if (!$invoice) {
                return redirect()->route('invoices.index')
                    ->with('error', 'Factuur niet gevonden.');
            }

            return view('invoices.edit', compact('invoice'));
        } catch (\Exception $e) {
            Log::error('Error fetching invoice for edit: ' . $e->getMessage());
            return redirect()->route('invoices.index')
                ->with('error', 'Er is een fout opgetreden bij het ophalen van de factuur.');
        }
    }

    /**
     * Werk een bestaande factuur bij.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number,'.$id,
            'invoice_date' => 'required|date',
            'status' => 'required|string|max:50',
            'amount_excl_vat' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'amount_incl_vat' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        try {
            DB::select('CALL spUpdateInvoice(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $validated['invoice_number'],
                $validated['invoice_date'],
                $validated['status'],
                $validated['amount_excl_vat'],
                $validated['vat'],
                $validated['amount_incl_vat'],
                $validated['note'] ?? null,
                isset($validated['is_active']) ? $validated['is_active'] : true,
            ]);

            return redirect()->route('invoices.index')
                ->with('success', 'Factuur succesvol bijgewerkt.');
        } catch (\Exception $e) {
            Log::error('Error updating invoice: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de factuur.');
        }
    }

    /**
     * Verwijder een factuur.
     */
    public function destroy($id)
    {
        try {
            // Check if invoice exists
            $invoice = collect(DB::select('CALL spGetInvoiceById(?)', [$id]))->first();

            if (!$invoice) {
                return redirect()->route('invoices.index')
                    ->with('error', 'Factuur niet gevonden.');
            }

            DB::select('CALL spDeleteInvoice(?)', [$id]);
            return redirect()->route('invoices.index')
                ->with('success', 'Factuur is succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Error deleting invoice: ' . $e->getMessage());
            return redirect()->route('invoices.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van de factuur.');
        }
    }
}