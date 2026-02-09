<?php

namespace Modules\Maps\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'zoom',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'zoom' => 'integer',
    ];
}

