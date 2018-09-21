<?php

namespace App\Http\Controllers\Api\v1;

use App\Cart;
use App\Category;
use App\Http\Controllers\Controller;
use App\Item;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Session;
use Validator;

class ItemController extends Controller
{
    public function getItems()
    {
        // retreive items with their categories
        $categories = Category::orderBy('created_at', 'desc')->get();
        $items = Item::orderBy('created_at', 'desc')->get();
        return response()->json(compact('items', 'categories'));
    }

    public function getCategoryItems($category_id)
    {
        // retreiving items of specific category
        $items = Category::find($category_id)->items;
        return response()->json(compact('items'));
    }

    public function addToCart($item_id)
    {
        // adding an item to the cart
        $item = Item::find($item_id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $item->id);
        Session::put('cart', $cart);
    }

    // reduce one item from the cart
    public function reduceItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('get_cart');
    }

    public function removeItem($item_id)
    {
        // removing all items from the cart
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($item_id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
    }

    public function getCart()
    {
        // get information of the current cart
        if (!Session::has('cart')) {
            return view('cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
    }

    public function checkout()
    {
        // redirect if the current session doesn't have a cart
        if (!Session::has('cart')) {
            return view('cart');
        }

        // checkout the cart contents
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $order = new Order();
        $order->cart = serialize($cart);
        Auth::user()->orders()->save($order);
        Session::forget('cart');
    }

    public function searchItems(Request $request)
    {
        // validating input
        $validator = Validator::make($request->all(), [
            'search' => 'required|max:30',
        ]);

        // return error if validator fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        // searching for an item and returning result
        $items = Item::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return response()->json(compact('items'));
    }
}
