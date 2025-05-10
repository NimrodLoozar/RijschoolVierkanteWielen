<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('contacts', 'students.user_id', '=', 'contacts.user_id')
            ->join('roles', 'students.user_id', '=', 'roles.user_id')
            ->select(
                'students.id', // Include the student ID
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'contacts.email',
                'roles.name as role_name'
            )
            ->where('roles.name', 'Leerling')
            ->get()
            ->toArray(); // Convert the result to an array

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $students = User::whereHas('roles', function ($query) {
            $query->where('name', 'Leerling');
        })->get();
        return view('students.create', compact('students'));
    }

    public function store(Request $request)
    {
        // Logica om een nieuwe student op te slaan
        return redirect()->route('students.index');
    }

    public function show($id)
    {
        // Logica om een specifieke student weer te geven
        return view('students.show', ['student' => $id]);
    }

    public function edit($id)
    {
        // Logica om een formulier voor het bewerken van een student weer te geven
        return view('students.edit', ['student' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Logica om de gegevens van een student bij te werken
        return redirect()->route('students.index');
    }

    public function destroy($id)
    {
        // Logica om een student te verwijderen
        return redirect()->route('students.index');
    }
}
