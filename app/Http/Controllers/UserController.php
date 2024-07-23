<?php

namespace App\Http\Controllers;

use App\Mail\CompteCreeMail;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function create()
    {
        // Typically handled by the frontend form
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:Admin,Utilisateur'
        ]);

        $user = User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['email'],
            'password' => bcrypt('password'),
            'role' => $validatedData['role'],
        ]);

        Mail::to($validatedData['email'])->send(new CompteCreeMail($user->nom, $user->prenom, 'password' ));

        return redirect()->route('admin.users');
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function edit(User $user)
    {
        // Typically handled by the frontend form
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'password' => 'sometimes|max:255'
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
        $user = User::find($id);

        if ($validatedData['password'] == NULL) {
            $user->nom = $validatedData['nom'];
            $user->prenom = $validatedData['prenom'];
            $user->save();
        } else {
            $user->update($validatedData);
        }

        return redirect()->route('user.home');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    public function signin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, true)) {
            // Authentifie l'utilisateur et crée un cookie de session persistant
            $request->session()->regenerate();

            if( Auth::user()->role == 'Admin'){
                return redirect()->route('admin.home');
            }else if( Auth::user()->role == 'Utilisateur' ){
                return redirect()->route('user.home');
            }
        }

        return view('/signin')->withErrors([
            'email' => 'Les informations d\'identification ne correspondent pas.',
        ]);
    }

    public function home() 
    {
        $taches = Tache::inRandomOrder()->limit(6)->get();
        $users = User::inRandomOrder()->limit(3)->get();
        return view('admin.home', compact('taches','users'));
    }

    public function user_home()
    {
        return view('user.home');
    }

    public function taches() 
    {
        $taches = Tache::orderBy('created_at', 'desc')->get();
        $users = User::all();
        return view('admin.taches', compact('taches', 'users'));
    }

    public function users() 
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function profile() 
    {
        return view('admin.profile');
    }

    public function promouvoir(int $id) 
    {
        $user = User::find($id);
        $user->role = "Admin";
        $user->save();
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
