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
        $categories = Category::orderBy('created_at','desc')->get();
        $items = Item::orderBy('created_at','desc')->get();
        return view('dashboard', compact('categories','items'));
    }

    public function getCategoryItems($category_id)
    {
        $items = Category::find($category_id)->items;
        return view('items',compact('items'));
    }

    public function getItemImage($filename)
    {
        $img = Image::make(Storage::disk('local')->get($filename));
        return $img->response('jpg');
    }

    public function addToCart($item_id)
    {
        $item = Item::find($item_id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $item->id);
        Session::put('cart', $cart);
        return redirect()->back();
    }


    public function removeItem($item_id) {
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
        if(!Session::has('cart')) {
            return view('cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('cart', compact('cart'));
    }

    public function checkout()
    {
        if(!Session::has('cart')) {
            return view('cart');
        }
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
        $items = Item::where('name', 'LIKE', '%'.$request->search.'%')->get();
        return view('search', compact('items'))->with('search', $request->search);
    }
}
