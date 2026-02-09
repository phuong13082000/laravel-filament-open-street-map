<?php

namespace Modules\Maps\Services;

class MapService
{
    public function defaultCenter(): array
    {
        return [
            'latitude' => 21.0278,
            'longitude' => 105.8342,
            'zoom' => 12,
        ];
    }
}

