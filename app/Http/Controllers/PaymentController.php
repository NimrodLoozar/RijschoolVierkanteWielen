<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Filters from query parameters
        $status = $request->query('status');      // e.g. 'paid', 'open'
        $fromDate = $request->query('from_date'); // format: 'YYYY-MM-DD'
        $toDate = $request->query('to_date');     // format: 'YYYY-MM-DD'

        $query = Payment::query()->where('is_active', 1);

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

        // Get payments ordered by date descending
        $payments = $query->orderBy('date', 'desc')->get();

        return view('betalingen.index', [
            'payments' => $payments,
            'filters' => compact('status', 'fromDate', 'toDate'),
        ]);
    }
}
