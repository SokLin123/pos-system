<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashController::class, 'dash'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//-------------------------------------------------------------------------------------------------


Route::get('/users', [UserController::class, 'index'])->name('user.index'); 
Route::post('/users/show/{id}', [UserController::class, 'show'])->name('products.show');
Route::post('/users/create', [UserController::class, 'create'])->name('user.create'); 
Route::post('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::post('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index'); 
Route::post('/suppliers/show/{id}', [SupplierController::class, 'show'])->name('supplier.show');
Route::post('/suppliers/create', [SupplierController::class, 'create'])->name('supplier.create'); 
Route::post('/suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::post('/suppliers/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::post('/suppliers/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

Route::get('/employees', [EmployeeController::class, 'index'])->name('employee.index'); 
Route::post('/employees/show/{id}', [EmployeeController::class, 'show'])->name('employee.show');
Route::post('/employees/create', [EmployeeController::class, 'create'])->name('employee.create'); 
Route::post('/employees/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::post('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');


// POS---------------------------------------------------------------------------------------------

Route::get('/pos', [PosController::class, 'index'])->name('Pos.index');

Route::get('/pos/category/{id}', [PosController::class, 'category'])->name('pos.category');

Route::post('/pos/cart/add', [PosController::class, 'add'])->name('cart.add');
Route::post('/pos/cart/update/{id}', [PosController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/pos/cart/increment/{id}', [PosController::class, 'increment'])->name('cart.increment');
Route::post('/pos/cart/decrement/{id}', [PosController::class, 'decrement'])->name('cart.decrement');

// -------------------------------------------------------------------------------------------------
Route::get('/pos/destroy.order', [PosController::class, 'destroy_order'])->name('destroy.order');
Route::get('/pos/order', [PosController::class, 'createInvoice'])->name('order');
Route::get('/pos/comfirm', [PosController::class, 'invoiceComfirm'])->name('comfirm');
// ---------------------------------------------------------------------------------------------

// PURCHASE---------------------------------------------------------------------------------------------

Route::get('/purchase', [PurchaseController::class, 'index'])->name('Purchase.index');

Route::get('/purchase/category/{id}', [PurchaseController::class, 'category'])->name('pos.category');

Route::post('/purchase/cart/add', [PurchaseController::class, 'add'])->name('cart.add');
Route::post('/purchase/cart/update/{id}', [PurchaseController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/purchase/cart/increment/{id}', [PurchaseController::class, 'increment'])->name('cart.increment');
Route::post('/purchase/cart/decrement/{id}', [PurchaseController::class, 'decrement'])->name('cart.decrement');

// -------------------------------------------------------------------------------------------------
Route::get('/purchase/destroy.order', [PurchaseController::class, 'destroy_order'])->name('destroy.order');
Route::get('/purchase/order', [PurchaseController::class, 'createInvoice'])->name('order');
Route::get('/purchase/comfirm', [PurchaseController::class, 'invoiceComfirm'])->name('comfirm');
// ---------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------

Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::post('/pos/get/unit', [PosController::class, 'getunit'])->name('getunit');
Route::post('/pos/cart/increment/{id}', [PosController::class, 'increment'])->name('cart.increment');
Route::post('/pos/cart/decrement/{id}', [PosController::class, 'decrement'])->name('cart.decrement');


Route::get('/sale', [PosController::class, 'sale_list'])->name('sale.index');

Route::get('/products', [ProductController::class, 'index'])->name('products.index'); 
Route::post('/products/show/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/create', [ProductController::class, 'create'])->name('products.create'); 
Route::post('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::post('/products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');

Route::get('/units', [UnitController::class, 'index'])->name('units.index'); 
Route::post('/units/create', [UnitController::class, 'create'])->name('units.create');
Route::post('/units/edit/{id}', [UnitController::class, 'edit'])->name('units.edit');
Route::post('/units/update/{id}', [UnitController::class, 'update'])->name('units.update');

Route::get('/category', [CategoryController::class, 'index'])->name('category.index'); 
Route::post('/category/create', [CategoryController::class, 'create'])->name('category.create'); 
Route::post('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');









Route::get('/purchase/add',function(){
    return view('purchase.add');
});

require __DIR__.'/auth.php';
