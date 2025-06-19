<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Registration;
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
        $searchCustomer = $request->input('searchCustomer', '');
        $searchStatus = $request->input('searchStatus', '');
        $searchDateFrom = $request->input('searchDateFrom', '');
        $searchDateTo = $request->input('searchDateTo', '');

        // Call the stored procedure
        try {
            $invoices = DB::select('CALL spGetAllInvoices()') ?? [];
            
            // Debug: Log the count of invoices returned by the SP
            Log::info('Invoices returned by SP: ' . count($invoices));
            
            if (empty($invoices)) {
                Log::warning('No invoices returned by spGetAllInvoices()');
            }
        } catch (\Exception $e) {
            // Log the error and return an empty array
            Log::error('Failed to fetch invoices: ' . $e->getMessage());
            $invoices = [];
        }

        // Convert the result to a collection
        $invoicesCollection = collect($invoices);

        // Apply filters if search parameters are provided
        if (!empty($searchInvoiceNumber) || !empty($searchCustomer) || !empty($searchStatus) || !empty($searchDateFrom) || !empty($searchDateTo)) {
            $invoicesCollection = $invoicesCollection->filter(function ($invoice) use ($searchInvoiceNumber, $searchCustomer, $searchStatus, $searchDateFrom, $searchDateTo) {
                $invoiceNumberMatch = empty($searchInvoiceNumber) || stripos($invoice->invoice_number, $searchInvoiceNumber) !== false;
                $customerMatch = empty($searchCustomer) || stripos($invoice->student_name ?? '', $searchCustomer) !== false;
                $statusMatch = empty($searchStatus) || $invoice->status == $searchStatus;
                
                $dateMatch = true;
                if (!empty($searchDateFrom)) {
                    $dateMatch = $dateMatch && $invoice->invoice_date >= $searchDateFrom;
                }
                if (!empty($searchDateTo)) {
                    $dateMatch = $dateMatch && $invoice->invoice_date <= $searchDateTo;
                }
                
                return $invoiceNumberMatch && $customerMatch && $statusMatch && $dateMatch;
            });
            
            // Debug: Log filtered count
            Log::info('Filtered invoices count: ' . $invoicesCollection->count());
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

        return view('invoices.index', compact(
            'paginatedInvoices', 
            'searchInvoiceNumber',
            'searchCustomer',
            'searchStatus',
            'searchDateFrom',
            'searchDateTo'
        ));
    }

    /**
     * Toon het formulier om een nieuwe factuur aan te maken.
     */
    public function create()
    {
        // Genereer het volgende factuurnummer
        $latestInvoice = Invoice::orderBy('id', 'DESC')->first();
        $nextInvoiceNumber = $latestInvoice ? 'INV-' . str_pad((intval(substr($latestInvoice->invoice_number, 4)) + 1), 6, '0', STR_PAD_LEFT) : 'INV-000001';

        // Get registrations for dropdown
        $registrations = DB::select('SELECT r.id, CONCAT(u.first_name, " ", u.last_name, " - ", p.type) AS description 
                                     FROM registrations r 
                                     JOIN students s ON r.student_id = s.id 
                                     JOIN users u ON s.user_id = u.id 
                                     JOIN packages p ON r.package_id = p.id');
        
        return view('invoices.create', compact('registrations', 'nextInvoiceNumber'));
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

         // Check if we should simulate an error
        if ($request->input('simulate_error') === '1') {
            Log::info('Simulating technical error during account creation');
            return back()->withInput()
                ->with('error', 'Factuur kon niet worden opgeslagen door een technische fout. Probeer het later opnieuw of neem contact op met support.');
        }

        // Genereer een nieuw factuurnummer als er geen is opgegeven
        if (empty($validated['invoice_number']) || $validated['invoice_number'] === 'AUTO') {
            $latestInvoice = Invoice::orderBy('id', 'DESC')->first();
            $validated['invoice_number'] = $latestInvoice ? 'INV-' . str_pad((intval(substr($latestInvoice->invoice_number, 4)) + 1), 6, '0', STR_PAD_LEFT) : 'INV-000001';
        }

        try {
            Log::info('Attempting to create invoice with number: ' . $validated['invoice_number']);
            
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
            
            Log::info('Invoice created successfully: ' . $validated['invoice_number']);
            
            return redirect()->route('invoices.index')
                ->with('success', 'Factuur succesvol aangemaakt.');
                
        } catch (\Exception $e) {
            // Check if the invoice was actually created despite the error
            $invoiceExists = Invoice::where('invoice_number', $validated['invoice_number'])->exists();
            
            if ($invoiceExists) {
                Log::warning('Exception occurred but invoice was created: ' . $e->getMessage());
                return redirect()->route('invoices.index')
                    ->with('success', 'Factuur succesvol aangemaakt.');
            }
            
            Log::error('Error creating invoice: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van de factuur: ' . $e->getMessage());
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

    /**
     * Markeer een factuur als betaald.
     */
    public function markAsPaid($id)
    {
        try {
            // Check if invoice exists
            $invoice = collect(DB::select('CALL spGetInvoiceById(?)', [$id]))->first();

            if (!$invoice) {
                return redirect()->route('invoices.index')
                    ->with('error', 'Factuur niet gevonden.');
            }

            if ($invoice->status === 'Betaald') {
                return redirect()->route('invoices.index')
                    ->with('info', 'Deze factuur is al gemarkeerd als betaald.');
            }

            // Use the existing update stored procedure to change status to 'Betaald'
            DB::select('CALL spUpdateInvoice(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $invoice->invoice_number,
                $invoice->invoice_date,
                'Betaald', // Change status to Betaald
                $invoice->amount_excl_vat,
                $invoice->vat,
                $invoice->amount_incl_vat,
                $invoice->note ?? null,
                $invoice->is_active ?? true,
            ]);

            return redirect()->route('invoices.index')
                ->with('success', 'Factuur is succesvol gemarkeerd als betaald.');
        } catch (\Exception $e) {
            Log::error('Error marking invoice as paid: ' . $e->getMessage());
            return redirect()->route('invoices.index')
                ->with('error', 'Er is een fout opgetreden bij het markeren van de factuur als betaald.');
        }
    }

    public function markAsUnpaid($id)
    {
        try {
            // Check if invoice exists
            $invoice = collect(DB::select('CALL spGetInvoiceById(?)', [$id]))->first();

            if (!$invoice) {
                return redirect()->route('invoices.index')
                    ->with('error', 'Factuur niet gevonden.');
            }

            if ($invoice->status === 'Onbetaald') {
                return redirect()->route('invoices.index')
                    ->with('info', 'Deze factuur is al gemarkeerd als onbetaald.');
            }

            // Use the existing update stored procedure to change status to 'Onbetaald'
            DB::select('CALL spUpdateInvoice(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $invoice->invoice_number,
                $invoice->invoice_date,
                'Onbetaald', // Change status to Onbetaald
                $invoice->amount_excl_vat,
                $invoice->vat,
                $invoice->amount_incl_vat,
                $invoice->note ?? null,
                $invoice->is_active ?? true,
            ]);

            return redirect()->route('invoices.index')
                ->with('success', 'Factuur is succesvol gemarkeerd als onbetaald.');
        } catch (\Exception $e) {
            Log::error('Error marking invoice as unpaid: ' . $e->getMessage());
            return redirect()->route('invoices.index')
                ->with('error', 'Er is een fout opgetreden bij het markeren van de factuur als onbetaald.');
        }
    }
}