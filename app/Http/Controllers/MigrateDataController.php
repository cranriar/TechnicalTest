<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MigrateDataController extends Controller
{
    public function migrateData(Request $request)
    {
        DB::beginTransaction();
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
            DB::commit();
            return response()->json(['message' => 'Migración completada'], 201);
        } catch (\Throwable $th) {
            Db::rollBack();
            dd($th);
            //throw $th;
        }


        return response()->json([
            'code' => 200,
            'message' => 'Migración de datos completada exitosamente',
            'data' => []
        ], 200);
    }

    public function updateData(Request $request){
        DB::beginTransaction();
        try {
            $character = Character::where('id', $request['id'])->first();
            if ($character) {
                $character->update([
                    'name' => $request['name'] ?? $character->name,
                    'status' => $request['status'] ?? $character->status,
                    'species' => $request['species'] ?? $character->species,
                    'type' => $request['type'] ?? $character->type,
                    'gender' => $request['gender'] ?? $character->gender,
                    'image' => $request['image'] ?? $character->image,
                    'created_at_api' => $request['created'] ?? $character->created_at_api,
                ]);
            }
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Datos Actualizados',
                'error' => null
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => 'Error al actualizar los datos',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
