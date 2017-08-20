<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUsers()
    {
        // retreiving all users
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function getOrders($user_id)
    {
        // retreiving orders of a user
        $orders = User::find($user_id)->orders;
        $orders->transform(function($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('admin.orders', compact('orders'));
    }
}
