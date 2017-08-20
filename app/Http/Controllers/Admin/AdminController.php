<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Admin;

class AdminController extends Controller
{
    // admin login
    public function login(Request $request)
    {
        // validating input
        $this->validate($request, [
            'email' => 'required|max:30',
            'password' => 'required|max:32'
        ]);

        // checking credentials and login + redirect if success
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]))
        return redirect()->route('admin_getUsers');

        // if login fails return back with error message
        $alert = "Email or password or both are not correct";
        return redirect()->back()->with(['alert' => $alert])->withInput();
    }

    // admin logout
    public function logout()
    {
        // admin logout and redirect
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard');
    }

    // used to create password hash for creating admin password in the database directly
    public function hashing(Request $request)
    {
        // creating password hash and returning the hash for usage
        $password = bcrypt($request->password);
        return $password;
    }
}
