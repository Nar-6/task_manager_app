<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::all();
        return response()->json($taches);
    }

    public function create()
    {
        // Typically handled by the frontend form
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_tache' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigne_a' => 'nullable|email|exists:users,email',
            'priorite' => 'required|in:High,Medium,Low',
            'statut' => 'required|in:À faire,En cours,Terminé',
        ]);

        $tache = Tache::create($validatedData);

        return response()->json($tache, 201);
    }

    public function show(Tache $tache)
    {
        return response()->json($tache);
    }

    public function edit(Tache $tache)
    {
        // Typically handled by the frontend form
    }

    public function update(Request $request, Tache $tache)
    {
        $validatedData = $request->validate([
            'nom_tache' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'assigne_a' => 'sometimes|nullable|email|exists:users,email',
            'priorite' => 'sometimes|required|in:High,Medium,Low',
            'statut' => 'sometimes|required|in:À faire,En cours,Terminé',
        ]);

        $tache->update($validatedData);

        return response()->json($tache);
    }

    public function destroy(Tache $tache)
    {
        $tache->delete();
        return response()->json(null, 204);
    }
}
