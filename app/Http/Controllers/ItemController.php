<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Auth;
use App\Category;
use App\Item;
use App\Cart;
use App\Order;
use Image;
use Session;

class ItemController extends Controller
{
    public function getItems()
    {
        // retreive items with their categories
        $categories = Category::orderBy('created_at','desc')->get();
        $items = Item::orderBy('created_at','desc')->get();
        return view('dashboard', compact('categories','items'));
    }

    public function getCategoryItems($category_id)
    {
        // retreiving items of specific category
        $items = Category::find($category_id)->items;
        return view('items',compact('items'));
    }

    public function getItemImage($filename)
    {
        // get the image of an item
        $img = Image::make(Storage::disk('local')->get($filename));
        return $img->response('jpg');
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
    public function reduceItem($id) {
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
        if(!Session::has('cart')) {
            return view('cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('cart', compact('cart'));
    }

    public function checkout()
    {
        // redirect if the current session doesn't have a cart
        if(!Session::has('cart')) {
            return view('cart');
        }

        // checkout the cart contents
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $order = new Order();
        $order->cart = serialize($cart);
        Auth::user()->orders()->save($order);
        Session::forget('cart');
        return redirect()->route('dashboard')->with('message', 'Successfully purchased products!');
    }

    public function searchItems(Request $request)
    {
        // validating input
        $this->validate($request, [
            'search' => 'required|max:30'
        ]);

        // searching for an item and returning result
        $items = Item::where('name', 'LIKE', '%'.$request->search.'%')->get();
        return view('search', compact('items'))->with('search', $request->search);
    }
}
