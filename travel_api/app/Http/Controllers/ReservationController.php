<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReservationController extends Controller
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
        $reservations = Reservation::all();
        return response()->json($reservations);
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
            'utilisateur_id' => 'required',
            'destination_id' => 'required',
            'date_de_départ' => 'required',
            'date_de_retour' => 'required',
            'nombre_de_voyageurs' => 'required|numeric',
            'option_de_paiement' => 'required',
            'tarif_total' => 'required|numeric',
        ]);

        $reservation = Reservation::create($validatedData);

        return response()->json($reservation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return response()->json($reservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validatedData = $request->validate([
            'utilisateur_id' => 'required',
            'destination_id' => 'required',
            'date_de_départ' => 'required',
            'date_de_retour' => 'required',
            'nombre_de_voyageurs' => 'required|numeric',
            'option_de_paiement' => 'required',
            'tarif_total' => 'required|numeric',
        ]);

        $reservation->update($validatedData);

        return response()->json($reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(null, 204);
    }
}
