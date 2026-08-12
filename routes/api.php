<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\PaiementController;

// Routes publiques (pas besoin d'être connecté)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Catalogue des services visible par tous
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

// Routes protégées (il faut un token valide)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Gestion des services réservée au gestionnaire
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    // Tickets : consultation, création, annulation
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);

    // Changement de statut (gestionnaire)
    Route::patch('/tickets/{ticket}/statut', [TicketController::class, 'changerStatut']);

    // Paiement d'un ticket (gestionnaire)
    Route::post('/tickets/{ticket}/paiement', [PaiementController::class, 'store']);
});
