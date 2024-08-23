<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Suppliers;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use App\Models\purchase;
use App\Models\purchase_detail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Units;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    
    public function index(Request $request)
    {
        $subtotal=0.00;
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = ($subtotal*0.10);
        $tax = ($subtotal-$discount)*0.05;
        $total = ($subtotal-$discount)+$tax;


        return view('purchase.index', [
            'products' => Products::all(),
            'categories' => Category::all(),
            'suppliers' => Suppliers::all(),
            'purchases' => Purchase::all(),
            'carts' => Cart::with('product')->get(),
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'subtotal' => $subtotal,
        ]);
    }


    public function getunit(Request $request)
    {
        $barcode = $request->input('barcode');

        $product = Products::where('barcode', $barcode)->first();

        if ($product) {
            $options = '';
            
            $unit = $product->units;

            $units = Units::where('group_unit_id',$unit)->get();  

            return response()->json($units);
        }

        return response('Product not found', 404);
    }


    public function add(Request $request)
    {
        $barcode = $request->input('barcode');
        $qty = $request->input('qty');

        // Validate that quantity is a positive integer
        if ($qty <= 0 || !is_numeric($qty)) {
            return response()->json([
                'error' => 'Quantity must be a positive number.'
            ], 400);
        }

        // Retrieve the product by barcode
        $product = Products::where('barcode', $barcode)->with('Category')->first();

        if ($product) {
            // Check if the product already exists in the cart
            $cartItem = Cart::where('product_id', $product->id)->first();

            if ($cartItem) {
                // If it exists, increment the quantity
                $cartItem->increment('qty_store', $qty);
            } else {
                // Otherwise, create a new cart item
                Cart::create([
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'barcode' => $product->barcode,
                    'category' => $product->Category->name,
                    'product_image' => $product->product_image,
                    'selling_price' => $product->selling_price,
                    'qty_store' => $qty,
                ]);
            }

            // Recalculate the cart totals
            $carts = Cart::all();
            $subtotal = $carts->sum(fn($cart) => $cart->selling_price * $cart->qty_store);
            $discount = $subtotal * 0.10; // 10% discount
            $tax = ($subtotal - $discount) * 0.05; // 5% tax
            $total = ($subtotal - $discount) + $tax;

            return response()->json([
                'carts' => $carts,
                'subtotal' => number_format($subtotal, 2),
                'discount' => number_format($discount, 2),
                'tax' => number_format($tax, 2),
                'total' => number_format($total, 2),
            ]);
        } else {
            // If the product is not found, return an error message
            return response()->json([
                'error' => 'Product not found.'
            ], 404);
        }
    }

    public function increment($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->increment('qty_store');
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = ($subtotal*0.10);
        $tax = ($subtotal-$discount)*0.05;
        $total = ($subtotal-$discount)+$tax;

        return response()->json([
            'cart' => $cartItem,
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'subtotal' => $subtotal
        ]);
    }
    public function decrement($id)
    {
        $cartItem = Cart::findOrFail($id);
    
        if ($cartItem->qty_store > 1) {
            // Decrement the quantity in the cart
            $cartItem->decrement('qty_store');
        } else {
            // If the quantity is 1 or less, remove the item from the cart
            $cartItem->delete();
        }
    
        // Recalculate cart totals
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = $subtotal * 0.10; // 10% discount
        $tax = ($subtotal - $discount) * 0.05; // 5% tax
        $total = ($subtotal - $discount) + $tax;
    
        return response()->json([
            'cart' => Cart::find($id), // If the item is deleted, this will return null
            'carts' => Cart::all(),    // Updated cart items
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'subtotal' => $subtotal,
        ]);
    }


    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $quantity = $request->input('qty');

        if ($quantity > 0) {
            $cartItem->qty_store = $quantity;
            $cartItem->save();
        } else {
            $cartItem->delete(); // Optionally, you can remove the item if quantity is set to 0
        }

        
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = ($subtotal*0.10);
        $tax = ($subtotal-$discount)*0.05;
        $total = ($subtotal-$discount)+$tax;

        return response()->json([
            'cart' => $cartItem,
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'subtotal' => $subtotal
        ]);
    }
    
    public function destroy_order()
    {
        Cart::truncate();

        return redirect()->route('Pos.index');
    }

    public function createInvoice(Request $request)
    {
        $invoice_no = IdGenerator::generate([
            'table' => 'orders',        // Use the plural, lowercase table name
            'field' => 'invoice_no',    // The field in the table
            'length' => 10,             // The length of the generated ID
            'prefix' => 'INV-',         // The prefix for the ID
        ]);

        session(['invoice_no' => $invoice_no]);

        $note = 'Buying on ' . now()->format('Y-m-d');
        $carts = Cart::all();
        
        $subtotal = $carts->sum(function($cart) {
            return $cart->selling_price * $cart->qty_store;
        });

        $discount = $subtotal * 0.10;
        $tax = ($subtotal - $discount) * 0.05;
        $total = ($subtotal - $discount) + $tax;

        return response()->json([
            'total' => $total, 
            'tax' => $tax,
            'carts' => $carts,
            'discount' => $discount,
            'subtotal' => $subtotal,
            'invoice_no' => $invoice_no,
        ]);
    }

    public function invoiceComfirm(Request $request)
    {
        
        $invoice_no = $request->session()->get('invoice_no');
    
        // Prepare note and reference strings
        $note = 'Buying on ' . now()->format('Y-m-d');
        $reference = 'Thank you to customer for buying from our shop at ' . now()->format('Y-m-d');
        
        // Calculate subtotal, discount, tax, and total
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = $subtotal * 0.10;
        $tax = ($subtotal - $discount) * 0.05;
        $total = ($subtotal - $discount) + $tax;
        $date = now()->format('Y-m-d');
        
        // Get all items in the cart
        $carts = Cart::all();
        
        // Create the sell record
        $sell = purchase::create([
            'user_id' => Auth::user()->id,
            'invoice_no' => $invoice_no,
            'reference' => $reference,
            'sell_date' => $date,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total_payment' => $total,
            'note' => $note,
        ]);
        
        // Update product quantities and create sell details
        foreach ($carts as $cart) {
            $product = Products::where('barcode', $cart->barcode)->first();
            if ($product) {
                $newQty = $product->qty_store - $cart->qty_store;
                $price = $product->selling_price * $cart->qty_store;
                $product->qty_store = $newQty;
                $product->save();
                
                purchase_detail::create([
                    'sell_id' => $sell->id,
                    'product_id' => $product->id,
                    'qty' => $cart->qty_store,
                    'unit_id' => $product->units,
                    'price' => $price,
                ]);
            }
        }
        
        // Clear session variables
        $request->session()->forget('invoice_no');
        $request->session()->forget('category');

        Cart::truncate();
        
        // Redirect to the POS index route
        return redirect()->route('Pos.index');
    }



    public function sale_list()
    {
        return view('sale.index',[
            'sales'=>purchase::all(),
        ]);
    }
}
