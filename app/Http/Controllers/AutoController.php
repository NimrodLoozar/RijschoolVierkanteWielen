<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auto;

class AutoController extends Controller
{
    public function index()
    {
        $autos = Auto::all(); // Fetch all autos
        return view('autos.index', compact('autos')); // Pass autos to the view
    }
}
