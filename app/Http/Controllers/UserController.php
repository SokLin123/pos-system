<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('users.index', [
            'users' => User::all(),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|file|max:1024',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        $fileName = null;
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/users/';
            $file->storeAs($path, $fileName);
        }
    
        $user = User::create([
            'photo' => $fileName,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        event(new Registered($user));
    
        return back()->with('success', 'User created successfully.');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'user' => $user,
        ]);
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'photo' => 'sometimes|nullable|image|file|max:1024',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        // Handle the photo file if uploaded
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
            $path = 'public/users/';
            
            // Delete old photo if exists
            if ($user->photo) {
                Storage::delete($path . $user->photo);
            }

            // Store the new photo and update the user's photo field
            $file->storeAs($path, $fileName);
            $user->photo = $fileName;
        }

        // Update the user with either the new data or keep the old data
        $user->update([
            'name' => $request->input('name', $user->name),
            'email' => $request->input('email', $user->email),
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'photo' => $user->photo, // This will use the new photo if uploaded, or the old one
        ]);

        return back()->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $user=User::find($id);

        if($user->photo){
            Storage::delete('public/users/' . $user->photo);
        }

        User::destroy($id);

        return back();
    }


}
