<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Firebase\JWT\JWT;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->get('/', function () {
    echo "<h1>Bienvenue sur l'API</h1>";
});

// Routes pour les utilisateurs
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/destinations', [DestinationController::class, 'index']); // Récupère toutes les destinations


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/users', [UserController::class, 'index']); // Récupère tous les utilisateurs
    Route::get('/users/{user}', [UserController::class, 'show']); // Récupère un utilisateur par son ID
    Route::put('/users/{user}', [UserController::class, 'update']);// Met à jour un utilisateur
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // Supprime un utilisateur

    // Routes pour les destinations

    Route::post('/destinations', [DestinationController::class, 'store']);// Crée une nouvelle destination
    Route::get('/destinations/{destination}', [DestinationController::class, 'show']); // Récupère une destination par son ID
    Route::put('/destinations/{destination}', [DestinationController::class, 'update']);// Met à jour une destination
    Route::delete('/destinations/{destination}', [DestinationController::class, 'destroy']); // Supprime une destination

    // Routes pour les réservations
    Route::get('/reservations', [ReservationController::class, 'index']); // Récupère toutes les réservations
    Route::post('/reservations', [ReservationController::class, 'store']); // Crée une nouvelle réservation
    Route::get('/reservations/{id}', [ReservationController::class, 'show']); // Récupère une réservation par son ID
    Route::put('/reservations/{id}', [ReservationController::class, 'update']); // Met à jour une réservation
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']); // Supprime une réservation

    // Routes pour les commentaires
    Route::get('/commentaires', [CommentaireController::class, 'index']); // Récupère tous les commentaires
    Route::post('/commentaires', [CommentaireController::class, 'store']); // Crée un nouveau commentaire
    Route::get('/commentaires/{id}', [CommentaireController::class, 'show']); // Récupère un commentaire par son ID
    Route::put('/commentaires/{id}', [CommentaireController::class, 'update']); // Met à jour un commentaire
    Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy']); // Supprime un commentaire
});
