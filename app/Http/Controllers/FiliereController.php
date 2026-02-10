<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    public function index()
    {
        $filieres = Filiere::withCount(['courses', 'enrollments'])->orderBy('nom')->get();

        return view('filieres.index', compact('filieres'));
    }

    public function create()
    {
        return view('filieres.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:filieres,code',
        ]);

        Filiere::create($data);

        return redirect()->route('filieres.index')->with('success', 'Filiere ajoutee.');
    }

    public function edit(Filiere $filiere)
    {
        return view('filieres.edit', compact('filiere'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:filieres,code,' . $filiere->id,
        ]);

        $filiere->update($data);

        return redirect()->route('filieres.index')->with('success', 'Filiere mise a jour.');
    }

    public function destroy(Filiere $filiere)
    {
        $filiere->delete();

        return redirect()->route('filieres.index')->with('success', 'Filiere supprimee.');
    }
}
