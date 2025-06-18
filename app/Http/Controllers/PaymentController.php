<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Filters from query parameters
        $status = $request->query('status');      // e.g. 'paid', 'open'
        $fromDate = $request->query('from_date'); // format: 'YYYY-MM-DD'
        $toDate = $request->query('to_date');     // format: 'YYYY-MM-DD'

        $query = Payment::query()
            ->where('is_active', 1)
            ->with('invoice'); // Add this line to eager load invoice relationship

        // Apply status filter if given
        if ($status) {
            $query->where('status', $status);
        }

        // Apply date filters if given
        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        // Gebruik paginate(3) in plaats van get()
        $payments = $query->orderBy('date', 'desc')->paginate(3);

        return view('betalingen.index', [
            'payments' => $payments,
            'filters' => compact('status', 'fromDate', 'toDate'),
        ]);
    }

    public function create()
    {
        // Get unpaid invoices for dropdown
        $invoices = DB::select('CALL spGetAllInvoices()');
        
        // Filter to only get unpaid/open invoices
        $unpaidInvoices = collect($invoices)->filter(function($invoice) {
            return $invoice->status !== 'paid';
        });

        return view('betalingen.create', compact('unpaidInvoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'invoice_number' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:open,paid,cancelled',
            'description' => 'nullable|string|max:255',
        ]);

        // Controleer op dubbele betaling
        $exists = \App\Models\Payment::where('invoice_id', $validated['invoice_id'])
            ->where('date', $validated['date'])
            ->where('status', $validated['status'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['duplicate' => 'Deze betaling bestaat al.']);
        }

        try {
            DB::transaction(function() use ($validated) {
                $payment = new Payment();
                $payment->invoice_id = $validated['invoice_id'];
                $payment->invoice_number = $validated['invoice_number'];
                $payment->date = $validated['date'];
                $payment->status = $validated['status'];
                $payment->description = $validated['description'];
                $payment->is_active = 1;
                $payment->save();

                // If payment is marked as paid, update the invoice status
                if ($validated['status'] === 'paid') {
                    DB::select('CALL spUpdateInvoice(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                        $validated['invoice_id'],
                        $validated['invoice_number'],
                        now(),
                        'paid',
                        // Get invoice details from stored procedure
                        DB::select('CALL spGetInvoiceById(?)', [$validated['invoice_id']])[0]->amount_excl_vat,
                        DB::select('CALL spGetInvoiceById(?)', [$validated['invoice_id']])[0]->vat,
                        DB::select('CALL spGetInvoiceById(?)', [$validated['invoice_id']])[0]->amount_incl_vat,
                        null,
                        true
                    ]);
                }
            });

            return redirect()
                ->route('betalingen.index')
                ->with('success', 'Betaling succesvol geregistreerd');
        } catch (\Exception $e) {
            Log::error('Error creating payment: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het registreren van de betaling.');
        }
    }
}
