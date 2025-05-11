<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

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
                'name' => 'Instructeur',
                'is_active' => true,
            ]);
            Log::info('Rol aangemaakt: ', $role->toArray());

            // Maak een nieuwe student aan
            $instructor = Instructor::create([
                'user_id' => $user->id,
                'number' => fake()->unique()->randomNumber(5, true),
                'is_active' => true,
            ]);
            Log::info('Instructor aangemaakt: ', $instructor->toArray());

            return redirect()->route('instructors.index')->with('success', 'Instructor created successfully.');
        } catch (Exception $e) {
            Log::error('Fout bij het aanmaken van de instructor: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Er is een fout opgetreden bij het aanmaken van de instructor.']);
        }
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
