<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MigrateDataController;
use App\Models\Character;

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

Route::get('/character-db', function () {
    $dataCache = Character::with(['origin', 'location', 'episodes'])->get()->map(function ($character) {
        return [
            'id' => $character->id,
            'name' => $character->name,
            'status' => $character->status,
            'species' => $character->species,
            'type' => $character->type,
            'gender' => $character->gender,
            'origin' => [
                'name' => $character->origin ? $character->origin->name : null,
                'url' => $character->origin ? $character->origin->url : null,
            ],
            'location' => [
                'name' => $character->location ? $character->location->name : null,
                'url' => $character->location ? $character->location->url : null,
            ],
            'image' => $character->image,
            'episode' => $character->episodes->pluck('url')->toArray(),
            'url' => $character->url,
            'created' => $character->created_at ? $character->created_at->toIso8601String() : null,
        ];
    });
    return response()->json([
        'code' => 200,
        'message' => 'Personajes obtenidos exitosamente',
        'data' => $dataCache
    ], 200);
});

Route::post('/migrate-data', [MigrateDataController::class, 'migrateData']);
Route::put('/update-data', [MigrateDataController::class, 'updateData']);

