<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;

class UserController extends Controller
{
    // user login
    public function login(Request $request)
    {
        // validating input
        $this->validate($request, [
            'email' => 'required|max:30',
            'password' => 'required|max:32'
        ]);

        // checking credintials and logging + redirect if sucsess
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Session::has('oldUrl')) {
                $oldUrl = Session::get('oldUrl');
                Session::forget('oldUrl');
                return redirect()->to($oldUrl);
            }
            return redirect()->route('dashboard');
        }

        // if registeration fails return back with error message
        $alert = "Email or password or both are not correct";
        return redirect()->back()->with(['alert' => $alert])->withInput();
    }

    // user registeration
    public function register(Request $request)
    {
        // validating input
        $this->validate($request, [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|min:4|max:32',
            'confirm_password' => 'required|same:password|min:4|max:32'
        ]);

        // creating new user and login + redirect if sucsess
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if($user->save()) {
            Auth::login($user);
            if (Session::has('oldUrl')) {
                $oldUrl = Session::get('oldUrl');
                Session::forget('oldUrl');
                return redirect()->to($oldUrl);
            }
            return redirect()->route('dashboard');
        }

        // if registeration fails return back with error message
        $alert = "Registeration has failed";
        redirect()->back()->with(['alert' => $alert]);
    }

    public function getOrders()
    {
        $orders = Auth::user()->orders;
        $orders->transform(function($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('user.orders', compact('orders'));
    }
    // user logout
    public function logout()
    {
        // user logout and redirect
        Auth::logout();
        return redirect()->route('dashboard');
    }
}
