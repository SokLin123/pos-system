<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Products;
use App\Models\Sell;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Sell_Detail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Units;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('order.index', [
            'orders' => Order::with(['customers'])->get(),
            'categories' => Category::all(),
            'suppliers' => Customer::all(),
            'units' => Units::all()
        ]);
    }


    public function category($id)
    {
        $catgory = $id;

        return redirect()->route('Pos.index')->with('catgory', $catgory);
    }


    public function add(Request $request)
    {
        $barcode = $request->barcode;
        $qty = $request->qty;
        $unit = $request->unit;
        $product = Products::where('barcode', $barcode)->with('Category')->first();
    
        if ($product) {
            $cartItem = Cart::where('product_id', $product->id)->first();
            if ($cartItem) {
                $cartItem->increment('qty_store', $qty);
            } else {
                Cart::create([
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'barcode' => $product->barcode,
                    'category' => $product->Category->name,
                    'product_image' => $product->product_image,
                    'selling_price' => $product->selling_price,
                    'qty_store' => $qty,
                    'unit' => $unit,
                ]);
            }
        }
    
        $carts = Cart::all();
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = $subtotal * 0.10;
        $tax = ($subtotal - $discount) * 0.05;
        $total = ($subtotal - $discount) + $tax;
    
        return response()->json([
            'carts' => $carts,
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'subtotal' => $subtotal
        ]);
    
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
            'qty_store' => $cartItem->qty_store,
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
            $cartItem->decrement('qty_store');
        } else {
            $cartItem->delete();
        }

        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = ($subtotal*0.10);
        $tax = ($subtotal-$discount)*0.05;
        $total = ($subtotal-$discount)+$tax;

        return response()->json([
            'qty_store' => $cartItem->qty_store,
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'subtotal' => $subtotal
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
            'qty_store' => $cartItem->qty_store,
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

        $note = 'Byying on '.now()->format('Y-m-d');
        $subtotal = Cart::sum(DB::raw('selling_price * qty_store'));
        $discount = ($subtotal*0.10);
        $tax = ($subtotal-$discount)*0.05;
        $total = ($subtotal-$discount)+$tax;
        $carts=Cart::all();

        return view('pos.invoice', [
            'total' => $total, 
            'tax' => $tax,
            'carts'=>$carts,
            'discount' => $discount,
            'subtotal' => $subtotal,
            'invoice_no'=> $invoice_no,
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
    $sell = Sell::create([
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
            
            Sell_Detail::create([
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
}
