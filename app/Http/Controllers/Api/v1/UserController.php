<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class UserController extends Controller
{
    // user login
    public function login(Request $request)
    {
        // validating input
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:30',
            'password' => 'required|max:32',
        ]);

        // return error if validator fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // checking credintials and logging
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the user with token
        $user = JWTAuth::toUser($token);
        $user->token = $token;
        return response()->json(compact('user'));
    }

    //user registeration
    public function register(Request $request)
    {
        // validating input
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|min:4|max:32',
            'confirm_password' => 'required|same:password|min:4|max:32',
        ]);

        // return error if validator fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // creating new user and login + redirect if sucsess
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // checking credintials and logging
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the user with token
        $user = JWTAuth::toUser($token);
        $user->token = $token;
        return response()->json(compact('user'));
    }

    public function getOrders(Request $request)
    {
        // get user orders
        $user = JWTAuth::toUser($request->header('Authorization'));
        $orders = $user->orders;
        return response()->json(compact('orders'));
    }

    public function getOrdersCart(Request $request)
    {
        // get cart items of specific order
        $user = JWTAuth::toUser($request->header('Authorization'));

        // validating input
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
        ]);

        // return error if validator fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $order = $user->orders->where('id', $request->order_id);

        // unserialize cart items from order
        $order->transform(function ($order, $key) {
            $order->cart = unserialize(base64_decode($order->cart));
            return $order;
        });

        if ($order->isNotEmpty()) {
            $cart = $order->first()->cart->items;
        } else {
            $cart = collect();
        }
        return response()->json(compact('cart'));
    }
}
