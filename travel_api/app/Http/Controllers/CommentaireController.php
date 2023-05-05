<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentaireController extends Controller
{
    /**
     * Afficher la liste des commentaires.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $commentaires = Commentaire::all();
        return response()->json($commentaires);
    }

    /**
     * Afficher le formulaire de création d'un nouveau commentaire.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('commentaires.create');
    }

    /**
     * Stocker un nouveau commentaire dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'utilisateur_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|max:255',
        ]);
    
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Utilisateur non authentifié.'], 401);
        }
    
        Commentaire::create([
            'utilisateur_id' => $request->utilisateur_id,
            'destination_id' => $request->destination_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);
    
        return redirect()->route('commentaires.index')
            ->with('success', 'Commentaire créé avec succès.');
    }
    

    /**
     * Afficher les détails d'un commentaire.
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function show(Commentaire $commentaire)
    {
        return view('commentaires.show', compact('commentaire'));
    }

    /**
     * Afficher le formulaire de modification d'un commentaire.
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function edit(Commentaire $commentaire)
    {
        return view('commentaires.edit', compact('commentaire'));
    }

    /**
     * Mettre à jour les informations d'un commentaire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|max:255',
        ]);
    
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Utilisateur non authentifié.'], 401);
        }

        $commentaire->update([
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('commentaires.index')
            ->with('success', 'Commentaire mis à jour avec succès.');
    }

    /**
     * Supprimer un commentaire de la base de données.
     *
     * @param  \App\Models\Commentaire  $commentaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Commentaire $commentaire)
    {
        $user = auth()->user();
        if ($user->id == $commentaire->utilisateur_id) {
            $commentaire->delete();
            return response()->json(['success' => 'Commentaire supprimé avec succès.']);
        } else {
            return response()->json(['error' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.'], 403);
        }
    }
}