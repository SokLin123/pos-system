<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class EmployeeController extends Controller
{
    
    public function index(Request $request)
    {
        return view('employee.index', [
            'employees' => Employee::all(),
        ]);
    }
    public function create(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:employees,email',
            'phone' => 'required|string|max:15|unique:employees,phone',
            'address' => 'required|string|max:100',
            'experience' => 'required|integer|min:0|max:50',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0|max:1000000',
        ]);

        $photo = null;

        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/employee/';

            $file->storeAs($path, $fileName);
            $photo = $fileName;
        }

        Employee::create([
            'photo' => $photo,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'experience' => $request->experience,
            'position' => $request->position,
            'salary' => $request->salary,
        ]);

        return back()->with('success', 'Employee has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        
        return response()->json([
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    
     public function edit($id)
     {
         $employee = Employee::findOrFail($id);
 
         if (!$employee) {
             return response()->json(['error' => 'Employee not found'], 404);
         }
 
         return response()->json([
             'employee' => $employee,
         ]);
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'photo' => 'sometimes|nullable|image|file|max:1024',
            'name' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:50|unique:employees,email,' . $id,
            'phone' => 'sometimes|required|string|max:15|unique:employees,phone,' . $id,
            'address' => 'sometimes|required|string|max:100',
            'experience' => 'sometimes|required|integer|min:0|max:50',
            'position' => 'sometimes|required|string|max:100',
            'salary' => 'sometimes|required|numeric|min:0|max:1000000',
        ]);

        $employee = Employee::find($id);

        $data = $request->only(['name', 'email', 'phone', 'address', 'experience', 'position', 'salary']);
        
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/employee/';
            
            // Delete the old photo if it exists
            if ($employee->photo) {
                Storage::delete($path . $employee->photo);
            }

            // Store the new photo
            $file->storeAs($path, $fileName);
            $data['photo'] = $fileName;
        }

        // Update only the fields that are present in the request
        $employee->update($data);

        return back()->with('success', 'Employee has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $employee=Employee::find($id);

        if($employee->photo){
            Storage::delete('public/employees/' . $employee->photo);
        }

        Employee::destroy($id);

        return back();
    }
}
