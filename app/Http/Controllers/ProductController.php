<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;
use App\Models\Category;
use App\Models\Suppliers;
use App\Models\Garage;
use App\Models\Units;
use Illuminate\Support\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('product.index', [
            'products' => Products::with(['category', 'supplier','units'])->get(),
            'categories' => Category::all(),
            'suppliers' => Suppliers::all(),
            'units' => Units::all(),
            'garages' => Garage::all(), // Corrected to lowercase 'garages'
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_image' => 'nullable|image|file|max:1024', // Allowing nullable for optional image uploads
            'category_id' => 'required|integer|exists:categories,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'garage_id' => 'required|integer|exists:garages,id',
            'unit_id' => 'required|integer|exists:units,id',
            'expire_date' => 'required|date_format:Y-m-d',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:buying_price',
        ]);

        // Generate a unique barcode
        $barcode = IdGenerator::generate([
            'table' => 'products',
            'field' => 'barcode',
            'length' => 6,
            'prefix' => 'P',
        ]);

        // Handle image upload
        $fileName = null; 
        if ($file = $request->file('product_image')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/products/';
            $file->storeAs($path, $fileName);
        }

        // Create a new product
        Products::create([
            'product_name' => $request->product_name,
            'barcode' => $barcode,
            'product_image' => $fileName,
            'garage_id' => $request->garage_id,
            'buy_date' => Carbon::now(),
            'expire_date' => $request->expire_date,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
        ]);

        return back()->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Products::where('id', $id)
            ->with(['category', 'supplier', 'garage','units'])
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'categories' => Category::all(),
            'suppliers' => Suppliers::all(),
            'garages' => Garage::all(),
            'units' => Units::all(),
            'product' => $product,
        ]);
    }
    
    public function show($id)
    {
        $product = Products::where('id', $id)
            ->with(['category', 'supplier', 'garage','units'])
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'product' => $product,
        ]);
    }

    

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'sometimes|required|string|max:255',
            'product_image' => 'sometimes|nullable|image|file|max:1024', // Allowing nullable for optional image uploads
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'supplier_id' => 'sometimes|required|integer|exists:suppliers,id',
            'garage_id' => 'sometimes|required|integer|exists:garages,id',
            'unit_id' => 'sometimes|required|integer|exists:units,id',
            'expire_date' => 'sometimes|required|date_format:Y-m-d',
            'buying_price' => 'sometimes|required|numeric|min:0',
            'selling_price' => 'sometimes|required|numeric|min:0|gte:buying_price',
        ]);

        $product = Products::find($id);

        // Handle image upload
        $fileName = $product->product_image; 
        if ($request->file('product_image')!=null) {
            $file = $request->file('product_image');
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/products/';
            if($product->product_image){
                Storage::delete($path . $product->product_image);
            }
            $file->storeAs($path, $fileName);
        }

        // Create a new product
        $product->update([
            'product_name' => $request->product_name,
            'product_image' => $fileName,
            'garage_id' => $request->garage_id,
            'expire_date' => $request->expire_date,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
        ]);

        return back()->with('success', 'Product Update successfully.');
    }

    public function delete($id){
        $product=Products::find($id);

        if($product->photo){
            Storage::delete('public/suppliers/' . $product->photo);
        }

        Products::destroy($id);

        return back();
    }

}
