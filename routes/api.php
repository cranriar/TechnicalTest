<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MigrateDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/character-api', function () {
    $dataCache = Cache::remember('rick_morty_personajes', now()->addDay(), function () {
        $data = [];
        for ($i = 1; $i < 101; $i++) {
            // Tu código aquí
            
            $response = Http::get("https://rickandmortyapi.com/api/character/$i");
            $data[] = $response->json();
        }
        return $data;
    });
    return response()->json([
        'code' => 200,
        'message' => 'Personajes obtenidos exitosamente',
        'data' => $dataCache
    ], 200);
});

Route::post('/migrate-data', [MigrateDataController::class, 'migrateData']);
