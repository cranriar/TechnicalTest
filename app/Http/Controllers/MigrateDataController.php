<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class MigrateDataController extends Controller
{
    public function migrateData(Request $request)
    {
        try {
            //code...
            foreach ($request->all() as $item) {
                // ORIGIN
                $origin = null;
                if (!empty($item['origin']['name'])) {
                    $origin = Location::firstOrCreate([
                        'name' => $item['origin']['name'],
                        'url' => $item['origin']['url'],
                    ]);
                }
    
                // LOCATION
                $location = null;
                if (!empty($item['location']['name'])) {
                    $location = Location::firstOrCreate([
                        'name' => $item['location']['name'],
                        'url' => $item['location']['url'],
                    ]);
                }
    
                // CHARACTER
                $character = Character::updateOrCreate(
                    ['url' => $item['url']],
                    [
                        'name' => $item['name'],
                        'status' => $item['status'],
                        'species' => $item['species'],
                        'type' => $item['type'],
                        'gender' => $item['gender'],
                        'image' => $item['image'],
                        'created_at_api' => $item['created'],
                        'origin_id' => $origin?->id,
                        'location_id' => $location?->id,
                    ]
                );
    
                // EPISODES
                if (!empty($item['episode'])) {
                    $episodeIds = [];
                    foreach ($item['episode'] as $episodeUrl) {
                        $episode = Episode::firstOrCreate(['url' => $episodeUrl]);
                        $episodeIds[] = $episode->id;
                    }
                    $character->episodes()->sync($episodeIds); // Vincula episodios
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
        }

        return response()->json(['message' => 'Migración completada'], 201);

        return response()->json([
            'code' => 200,
            'message' => 'Migración de datos completada exitosamente',
            'data' => []
        ], 200);
    }
}
