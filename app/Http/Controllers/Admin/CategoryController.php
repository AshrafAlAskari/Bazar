<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function getCategories()
    {
        // retreiving all categories
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.categories', compact('categories'));
    }

    public function addCategory(Request $request)
    {
        // validating input
        $this->validate($request, [
            'name' => 'required|max:30'
        ]);

        //Creating new category
        $category = new Category();
        $category->name = $request->name;
        $message = 'There was an error';
        if ($category->save()) {
            $message = 'Successfully added!';
        }

        // redirecting with info message
        return redirect()->route('admin_getCategories')->with(['message' => $message]);
    }

    public function editCategory(Request $request)
    {
        // validating input
        $this->validate($request, [
            'category_name' => 'required|max:30',
        ]);

        // finding targeted category, update it and return the update
        $category = Category::find($request->category_id);
        $category->name = $request->category_name;
        $category->update();
        return response()->json(['category_name' => $category->name], 200);
    }

    public function deleteCategory(Request $request)
    {
        // delete a category if it has not items
        if (Category::find($request->category_id)->items->isEmpty()) {
            Category::find($request->category_id)->delete();
        } else {
            return response()->json(['message' => 'Category is not empty, please delete related items first'], 200);
        }


    }
}
