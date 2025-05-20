<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // Logica om een lijst van facturen op te halen
        return view('invoices.index');
    }
}