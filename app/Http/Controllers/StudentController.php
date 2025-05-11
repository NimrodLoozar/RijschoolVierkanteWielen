<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

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
            ->orderBy('students.created_at', 'desc') // Order by creation date, descending
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
        // Valideer de invoer
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'street' => ['required', 'string', 'max:255'], // Fixed rule
            'house_number' => ['required', 'string', 'max:255'], // Fixed rule
            'postal_code' => ['required', 'string', 'max:255'], // Fixed rule
            'city' => ['required', 'string', 'max:255'], // Fixed rule
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:contacts,email'],
            'birth_date' => ['required', 'date'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Maak een nieuwe gebruiker aan
            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'birth_date' => $request->birth_date,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            Log::info('Gebruiker aangemaakt: ', $user->toArray());

            // Maak een nieuwe contactpersoon aan
            $contact = Contact::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'street' => $request->street,
                'house_number' => $request->house_number,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
                'is_active' => true,
            ]);
            Log::info('Contact aangemaakt: ', $contact->toArray());

            // Koppel de rol 'Leerling' aan de gebruiker
            $role = Role::create([
                'user_id' => $user->id,
                'name' => 'Leerling',
                'is_active' => true,
            ]);
            Log::info('Rol aangemaakt: ', $role->toArray());

            // Maak een nieuwe student aan
            $student = Student::create([
                'user_id' => $user->id,
                'relation_number' => \Faker\Factory::create()->unique()->regexify('STU-[0-9]{8}'),
                'is_active' => true,
            ]);
            Log::info('Student aangemaakt: ', $student->toArray());

            return redirect()->route('students.index')->with('success', 'Student created successfully.');
        } catch (Exception $e) {
            Log::error('Fout bij het aanmaken van de student: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Er is een fout opgetreden bij het aanmaken van de student.']);
        }
    }

    public function show($id)
    {
        // Logica om een specifieke student weer te geven
        return view('students.show', ['student' => $id]);
    }

    public function edit($id)
    {
        // Logica om een formulier voor het bewerken van een student weer te geven
        $student = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('contacts', 'students.user_id', '=', 'contacts.user_id')
            ->join('roles', 'students.user_id', '=', 'roles.user_id')
            ->select(
                'students.id',
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'users.username',
                'users.birth_date',
                'contacts.email',
                'contacts.street',
                'contacts.house_number',
                'contacts.postal_code',
                'contacts.city',
                'roles.name as role_name'
            )
            ->where('students.id', $id)
            ->first();

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Start update van leerling met ID: ' . $id);

        $student = Student::findOrFail($id);
        Log::info('Leerling gevonden: ', $student->toArray());

        $user = $student->user;
        Log::info('Gebruiker gekoppeld aan leerling: ', $user->toArray());

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'street' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:contacts,email,' . $user->id . ',user_id'],
            'birth_date' => ['required', 'date'],
        ]);
        Log::info('Validatie succesvol uitgevoerd.');

        try {
            $user->update([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'birth_date' => $request->birth_date,
            ]);
            Log::info('Gebruiker succesvol bijgewerkt: ', $user->toArray());

            $contact = Contact::where('user_id', $user->id)->firstOrFail();
            Log::info('Contactpersoon gevonden: ', $contact->toArray());

            $contact->update([
                'email' => $request->email,
                'street' => $request->street,
                'house_number' => $request->house_number,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
            ]);
            Log::info('Contactpersoon succesvol bijgewerkt: ', $contact->toArray());

            Log::info('Update van leerling met ID ' . $id . ' succesvol afgerond.');
            return redirect()->route('students.index')->with('success', 'Instructor updated successfully.');
        } catch (Exception $e) {
            Log::error('Fout bij het bijwerken van de leerling: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Er is een fout opgetreden bij het bijwerken van de instructor.']);
        }
    }
    public function destroy($id)
    {
        // Logica om een leerling te verwijderen
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Instructor deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Er is een fout opgetreden bij het verwijderen van de instructor.']);
        }
    }
}
