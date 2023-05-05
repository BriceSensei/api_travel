<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Destination;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $revenuesByMonth = $this->getRevenuesByMonth();
        $numberOfNewCustomers = $this->getNumberOfNewCustomers();
        $numberOfExistingCustomers = $this->getNumberOfExistingCustomers();
        $topDestinations = $this->getTopDestinations();
        $averageFillRate = $this->getAverageFillRate();
        
        // Return data as JSON
        return response()->json([
            'revenuesByMonth' => $revenuesByMonth,
            'numberOfNewCustomers' => $numberOfNewCustomers,
            'numberOfExistingCustomers' => $numberOfExistingCustomers,
            'topDestinations' => $topDestinations,
            'averageFillRate' => $averageFillRate
        ]);
    }

    // Récupération des réservations groupées par mois et année
    private function getRevenuesByMonth()
    {
        $reservations = Reservation::selectRaw('YEAR(date_de_depart) as year, MONTH(date_de_depart) as month, SUM(tarif_total) as revenue')
            ->groupBy('year', 'month')
            ->get();

        $revenuesByMonth = [];
        foreach ($reservations as $reservation) {
            $revenuesByMonth[$reservation->year][$reservation->month] = $reservation->revenue;
        }
        return $revenuesByMonth;
    }

    // Récupération du nombre de nouveaux clients
    private function getNumberOfNewCustomers()
    {
        return User::join('reservations', 'users.id', '=', 'reservations.utilisateur_id')
            ->whereRaw('users.created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
            ->distinct()
            ->count('users.id');
    }

    // Récupération du nombre de clients existants
    private function getNumberOfExistingCustomers()
    {
        return User::join('reservations', 'users.id', '=', 'reservations.utilisateur_id')
            ->whereRaw('users.created_at < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)')
            ->distinct()
            ->count('users.id');
    }

    // Récupération du top 5 des destinations les plus populaires
    private function getTopDestinations()
    {
        return Destination::select('id', 'nom')
            ->withCount(['reservations' => function ($query) {
                $query->where('statut', '=', 'confirmee');
            }])
            ->orderByDesc('reservations_count')
            ->limit(5)
            ->get();
    }

    // Récupération du pourcentage de remplissage moyen des destinations
    private function getAverageFillRate()
    {
        return Destination::avg('taux_remplissage');
    }
}
