<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = DB::table('instructors')
            ->join('users', 'instructors.user_id', '=', 'users.id')
            ->join('contacts', 'instructors.user_id', '=', 'contacts.user_id')
            ->join('roles', 'instructors.user_id', '=', 'roles.user_id')
            ->select(
                'instructors.id',
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'contacts.email',
                'roles.name as role_name'
            )
            ->where('roles.name', 'Instructeur')
            ->get()
            ->toArray();
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        // Logica om een formulier voor het maken van een nieuwe instructeur weer te geven
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        // Logica om een nieuwe instructeur op te slaan
        return redirect()->route('instructors.index');
    }

    public function show($id)
    {
        // Logica om een specifieke instructeur weer te geven
        return view('instructors.show', ['instructor' => $id]);
    }

    public function edit($id)
    {
        // Logica om een formulier voor het bewerken van een instructeur weer te geven
        return view('instructors.edit', ['instructor' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logica om de gegevens van een instructeur bij te werken
        return redirect()->route('instructors.index');
    }
}
