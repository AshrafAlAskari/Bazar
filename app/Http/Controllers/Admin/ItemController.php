<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\Category;
use Storage;
use File;

class ItemController extends Controller
{
    public function getItems()
    {
        // retreiving all items
        $items = Item::orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('admin.items', compact('items', 'categories'));
    }

    public function addItem(Request $request)
    {
        // validating input
        $this->validate($request, [
            'category' => 'required',
            'name' => 'required|max:30',
            'info' => 'required|max:200',
            'price' => 'required|max:10000000',
            'image' => 'required'
        ]);

        //Creating new item
        $item = new Item();
        $item->name = $request->name;
        $item->info = $request->info;
        $item->price = $request->price;
        $message = 'There was an error';

        // preparing image name to be saved to the DB
        $file = $request->file('image');
        $random = str_random(16);
        $filename = $random. '.jpg';
        if ($file) {
            $item->image = $filename;
            Storage::disk('local')->put($filename, File::get($file));
        }
        if (Category::find($request->category)->items()->save($item)) {
            $message = 'Successfully added!';
        }

        // redirecting with info message
        return redirect()->route('admin_getItems')->with(['message' => $message]);
    }

    public function editItem(Request $request)
    {
        $this->validate($request, [
            'item_name' => 'required|max:30',
            'item_info' => 'required|max:200',
            'item_price' => 'required|max:10000000'
        ]);
        $item = Item::find($request->item_id);
        $item->name = $request->item_name;
        $item->info = $request->item_info;
        $item->price = $request->item_price;
        $item->update();
        return response()->json([['item_name' => $item->name],['item_info' => $item->info],['item_price' => $item->price]], 200);
    }

    public function deleteItem(Request $request)
    {
        // delete a item
        Item::find($request->item_id)->delete();
    }
}
