<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Units;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        return view('unit.index', [
            'units' => Units::all(),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:255',
            'note' => 'required|string|min:1',
        ]);

        // Create a new product
        Units::create([
            'name' => $request->unit_name,
            'abbreviation' => $request->abbreviation,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $unit = Units::findOrFail($id);

        if (!$unit) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json([
            'unit' => $unit,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_name' => 'sometimes|required|string|max:255',
            'abbreviation' => 'sometimes|required|string|max:255',
            'node' => 'sometimes|required|string|min:1',
        ]);

        $unit = Units::find($id);

        // Handle image upload

        // Create a new product
        $unit->update([
            'name' => $request->unit_name,
            'abbreviation' => $request->abbreviation,
            'node' => $request->node
        ]);

        return back()->with('success', 'Product Update successfully.');
    }
}
