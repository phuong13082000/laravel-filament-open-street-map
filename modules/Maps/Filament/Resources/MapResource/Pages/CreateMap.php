<?php

namespace Modules\Maps\Filament\Resources\MapResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Maps\Filament\Resources\MapResource;

class CreateMap extends CreateRecord
{
    protected static string $resource = MapResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $mapState = $data['map_state'] ?? [];

        $data['latitude'] = $mapState['lat'] ?? null;
        $data['longitude'] = $mapState['lng'] ?? null;
        $data['zoom'] = $mapState['zoom'] ?? null;

        unset($data['map_state']);

        return $data;
    }
}

