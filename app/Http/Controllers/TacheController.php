<?php

namespace App\Http\Controllers;

use App\Mail\TacheAssigneMail;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        ], [
            'nom_tache.required' => 'Le titre de la tâche est obligatoire.',
            'nom_tache.string' => 'Le titre de la tâche doit être une chaîne de caractères.',
            'nom_tache.max' => 'Le titre de la tâche ne peut pas dépasser 255 caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'assigne_a.email' => 'L\'adresse e-mail doit être valide.',
            'assigne_a.exists' => 'L\'utilisateur assigné doit exister dans la base de données.',
            'priorite.required' => 'La priorité de la tâche est obligatoire.',
            'priorite.in' => 'La priorité de la tâche doit être soit High, Medium ou Low.',
        ]);

        $tache = new Tache();
        $tache->nom_tache = $validatedData['nom_tache'];
        $tache->description = $validatedData['description'];
        $tache->assigne_a = $validatedData['assigne_a'];
        $tache->priorite = $validatedData['priorite'];
        $tache->save();

        if ($tache->assigne_a) {
            $user = User::where('email', $tache->assigne_a)->first();
            Mail::to($user->email)->send(new TacheAssigneMail($user->nom, $user->prenom));
        }

        return redirect()->route('admin.taches');
    }

    public function show(Tache $tache)
    {
        return response()->json($tache);
    }

    public function edit(Tache $tache)
    {
        // Typically handled by the frontend form
    }

    public function update(Request $request,int $num_tache)
    {
        $validatedData = $request->validate([
            'nom_tache' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'assigne_a' => 'sometimes|nullable|email|exists:users,email',
        ]);

        $tache = Tache::find($num_tache);
        $tache->update($validatedData);

        return redirect()->route('admin.taches');
    }

    public function high(int $num_tache) 
    {
        $tache = Tache::find($num_tache);
        $tache->priorite = "High";
        $tache->save();
        return redirect()->route('admin.taches');
    }

    public function medium(int $num_tache) 
    {
        $tache = Tache::find($num_tache);
        $tache->priorite = "Medium";
        $tache->save();
        return redirect()->route('admin.taches');
    }

    public function low(int $num_tache) 
    {
        $tache = Tache::find($num_tache);
        $tache->priorite = "Low";
        $tache->save();
        return redirect()->route('admin.taches');
    }

    public function encours(int $num_tache) 
    {
        $tache = Tache::find($num_tache);
        $tache->statut = "En cours";
        $tache->save();
        return redirect()->back();
    }

    public function termine(int $num_tache) 
    {
        $tache = Tache::find($num_tache);
        $tache->statut = "Terminé";
        $tache->save();
        return redirect()->back();
    }


    public function destroy(int $num_tache)
    {
        $tache = Tache::find($num_tache);
        $tache->delete();
        return redirect()->route('admin.taches');
    }
}
