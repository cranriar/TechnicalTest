<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'status', 'species', 'type', 'gender',
        'image', 'url', 'created_at_api', 'origin_id', 'location_id'
    ];

    protected $casts = [
        'created_at_api' => 'datetime',
    ];

    public function origin()
    {
        return $this->belongsTo(Location::class, 'origin_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function episodes()
    {
        return $this->belongsToMany(Episode::class);
    }
}
