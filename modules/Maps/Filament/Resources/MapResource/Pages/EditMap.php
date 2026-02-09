<?php

namespace Modules\Maps\Filament\Resources\MapResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\Maps\Filament\Resources\MapResource;

class EditMap extends EditRecord
{
    protected static string $resource = MapResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['map_state'] = [
            'lat' => $data['latitude'] ?? null,
            'lng' => $data['longitude'] ?? null,
            'zoom' => $data['zoom'] ?? null,
        ];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $mapState = $data['map_state'] ?? [];

        $data['latitude'] = $mapState['lat'] ?? null;
        $data['longitude'] = $mapState['lng'] ?? null;
        $data['zoom'] = $mapState['zoom'] ?? null;

        unset($data['map_state']);

        return $data;
    }
}

