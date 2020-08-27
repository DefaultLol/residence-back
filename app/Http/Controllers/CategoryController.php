<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        Category::create($request->validate([
            'name'=>'required'
        ]));

        return response()->json(['message'=>'Category created succefully']);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate([
            'name'=>'required'
        ]));

        return response()->json(['message'=>'Category updated succefully']);
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json(['message'=>'Category deleted succefully']);
    }
}
