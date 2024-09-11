<?php
namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index()
    {
        $bonuses = Bonus::all();
    
        return response()->json($bonuses);
    }

    // public function create()
    // {
    //     return view('bonuses.create');
    // }
    public function getBonusById($id)
    {
        $bonus = Bonus::find($id);

        if ($bonus) {
            return response()->json($bonus);
        } else {
            return response()->json(['message' => 'Bonus not found'], 404);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'size' => 'nullable|string|max:255',
        ]);

        Bonus::create($request->all());

        return redirect()->route('bonuses.index')->with('success', 'Bonus created successfully.');
    }

    public function show(Bonus $bonus)
    {
        return view('bonuses.show', compact('bonus'));
    }

    public function edit(Bonus $bonus)
    {
        return view('bonuses.edit', compact('bonus'));
    }

    public function update(Request $request, Bonus $bonus)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'size' => 'nullable|string|max:255',
        ]);

        $bonus->update($request->all());

        return redirect()->route('bonuses.index')->with('success', 'Bonus updated successfully.');
    }

    public function destroy(Bonus $bonus)
    {
        $bonus->delete();

        return redirect()->route('bonuses.index')->with('success', 'Bonus deleted successfully.');
    }
}
