<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Category;
use App\Item;
use App\Order;
use Auth;
use Illuminate\Http\Request;
use Session;

class ItemController extends Controller
{
    public function getItems()
    {
        // retreive items with their categories
        $categories = Category::orderBy('created_at', 'desc')->get();
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('categories', 'items'));
    }

    public function getCategoryItems($category_id)
    {
        // retreiving items of specific category
        $categories = Category::orderBy('created_at', 'desc')->get();
        if (Category::find($category_id)) {
            $items = Category::find($category_id)->items;
        } else {
            $items = collect();
        }

        return view('items', compact('categories', 'items', 'category_id'));
    }

    public function sortByPrice($category_id)
    {
        // retreive items according to price
        $categories = Category::orderBy('created_at', 'desc')->get();
        if (Category::find($category_id)) {
            $items = Category::find($category_id)->items_sort;
        } else {
            $items = collect();
        }

        return view('items', compact('categories', 'items', 'category_id'));
    }

    public function filterByPrice($category_id, Request $request)
    {
        // validating input
        $this->validate($request, [
            'min' => 'required|max:10000000',
            'max' => 'required|max:10000000',
        ]);

        // retreive items according to specified price
        $categories = Category::orderBy('created_at', 'desc')->get();
        $items = Item::where('category_id', $category_id)->whereBetween('price', [$request->min, $request->max])->get();
        return view('items', compact('categories', 'items', 'category_id'));
    }

    public function addToCart($item_id)
    {
        // adding an item to the cart
        $item = Item::find($item_id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $item->id);
        Session::put('cart', $cart);
        return redirect()->back();
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
        return redirect()->route('get_cart');
    }

    public function getCart()
    {
        // get information of the current cart
        if (!Session::has('cart')) {
            return view('cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('cart', compact('cart'));
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
        $order->cart = base64_encode(serialize($cart));
        Auth::user()->orders()->save($order);
        Session::forget('cart');
        return redirect()->route('dashboard')->with('message', 'Successfully purchased products!');
    }

    public function searchItems(Request $request)
    {
        // validating input
        $this->validate($request, [
            'search' => 'required|max:30',
        ]);

        // searching for an item and returning result
        $items = Item::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('search', compact('items'))->with('search', $request->search);
    }
}
