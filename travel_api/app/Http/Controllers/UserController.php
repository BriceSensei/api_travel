<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['index', 'show', 'store', 'login']]);
    }

    /**
     * Récupère tous les utilisateurs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users, 200);
    }

    /**
     * Enregistre un nouvel utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'email' => 'required|unique:users',
            'mot_de_passe' => 'required|min:8',
            'role' => 'required|in:employe,client'
        ]);

        $user = new User();
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->mot_de_passe = Hash::make($request->mot_de_passe);
        $user->role = $request->role;
        $user->save();

        $token = Auth::login($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Affiche un utilisateur spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Met à jour un utilisateur spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $request->validate([
            'nom' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'role' => 'required|in:employe,client'
        ]);

        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Supprime un utilisateur spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé'], 200);
    }



public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'mot_de_passe' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe)) {
        return response()->json(['error' => 'informations invalides'], 401);
    }

    $token = JWTAuth::fromUser($user);

    return response()->json(['token' => $token], 200);
}
}
