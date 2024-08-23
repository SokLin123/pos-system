<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        return view('supplier.index', [
            'suppliers' => Suppliers::all(),
        ]);
    }

    public function create(Request $request)
    { 
        $request->validate([
            'photo' => 'required|image|file|max:1024',
            'company_name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:suppliers,email',
            'phone' => 'required|string|max:15|unique:suppliers,phone',
            'address' => 'required|string|max:100',
            'note' => 'required|string|min:1',
        ]);

        $VANTTIN_num = IdGenerator::generate([
            'table' => 'suppliers',
            'field' => 'VANTTIN_num',
            'length' => 6,
            'prefix' => 'SP',
        ]);
        
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/suppliers/';

            $file->storeAs($path, $fileName);
            $photo = $fileName;
        }

        Suppliers::create([
            'photo' => $photo,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'VANTTIN_num' => $VANTTIN_num,
        ]);

        return back()->with('success', 'Supplier has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Suppliers::where('id', $id)
            ->first();

        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
        
        return response()->json([
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    
     public function edit($id)
     {
         $supplier = Suppliers::where('id', $id)->first();
 
         if (!$supplier) {
             return response()->json(['error' => 'Supplier not found'], 404);
         }
 
         return response()->json([
             'supplier' => $supplier,
         ]);
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'photo' => 'sometimes|nullable|image|file|max:1024',
            'company_name' => 'sometimes|string|max:50',
            'email' => 'sometimes|email|max:50|unique:suppliers,email,'.$id,
            'phone' => 'sometimes|string|max:15|unique:suppliers,phone,'.$id,
            'address' => 'sometimes|string|max:100',
            'note' => 'sometimes|string|min:1',

        ]);

        $supplier=Suppliers::findOrFail($id);


        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/suppliers/';
            if($supplier->photo){
                $path = 'public/suppliers/';
                Storage::delete($path . $supplier->photo);
            }
            $file->storeAs($path, $fileName);
            $photo = $fileName;
        }

        $supplier->update([
            'photo' => $photo,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Supplier has been created!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $supplier=Suppliers::find($id);

        if($supplier->photo){
            Storage::delete('public/suppliers/' . $supplier->photo);
        }

        Suppliers::destroy($id);

        return back();
    }

}
