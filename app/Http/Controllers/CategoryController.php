<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('category.index', [
            'Categories' => Category::all(),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'note' => 'required|string|min:1',
        ]);

        // Create a new product
        Category::create([
            'name' => $request->category_name,
            'code' => $request->code,
            'note' => $request->node,
        ]);

        return back()->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        if (!$category) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'categories' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:255',
            'note' => 'sometimes|required|string|min:1',
        ]);

        $category = Category::find($id);


        // Create a new product
        $category->update([
            'name' => $request->name,
            'code' => $request->code,
            'note' => $request->node
        ]);

        return back()->with('success', 'Product Update successfully.');
    }
}
