<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class DestinationController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Destination::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|url',
            'emplacement' => 'required|max:255',
            'prix' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $destination = Destination::create($validatedData);

        return response()->json($destination, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);
        try {
            $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $destination = Destination::findOrFail($id);
            return $destination;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token invalide'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Destination $destination)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required',
            'image' => 'required|url',
            'emplacement' => 'required|max:255',
            'prix' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $destination->update($validatedData);

        return response()->json($destination, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();

        return response()->json(null, 204);
    }
}
