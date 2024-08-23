<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Products;
use App\Models\purchase;
use App\Models\purchase_detail;
use App\Models\Sell;
use App\Models\Sell_Detail;
use App\Models\Suppliers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    public function dash()
    {
        $sale_t_due = Sell::sum('total_payment') - Sell_Detail::join('products', 'sell__details.product_id', '=', 'products.id')->sum('products.buying_price');
        $sale_p_year = Sell::select(DB::raw('MONTH(sell_date) as month'), DB::raw('SUM(total_payment) as payments'))->whereYear('sell_date', Carbon::now()->year)->groupBy(DB::raw('MONTH(sell_date)'))->orderBy(DB::raw('MONTH(sell_date)'))->get();
        $purchase_p_year = purchase::select(DB::raw('MONTH(purchase_date) as month'), DB::raw('SUM(total_payment) as payments'))->whereYear('purchase_date', Carbon::now()->year)->groupBy(DB::raw('MONTH(purchase_date)'))->orderBy(DB::raw('MONTH(purchase_date)'))->get();

        return view('dashboard', [
            'num_product' => Products::count(),
            'employee' => Employee::count(),
            'customer' => Customer::count(),
            'supplier' => Suppliers::count(),
            'purchase' => purchase::count(),
            'sale' => Sell::count(),
            'sale_p_year' => $sale_p_year,
            'purchase_p_year' => $purchase_p_year,
            'total_sele' => Sell::sum('total_payment'),
            'total_sele_due' => $sale_t_due,
            'total_purchase_due' => purchase::sum('subtotal'),
            'total_expense' => purchase::sum('total_payment'),
            'category' => Category::count(),
        ]);
    }
}
