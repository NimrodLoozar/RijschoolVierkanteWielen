use Illuminate\Http\Request;

<?php

namespace App\Http\Controllers;


class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Code to list all users
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Code to show form for creating a new user
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Code to store a new user
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        // Code to display a specific user
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        // Code to show form for editing a user
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        // Code to update a user
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        // Code to delete a user
    }
}
