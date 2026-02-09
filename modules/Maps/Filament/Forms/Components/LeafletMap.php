<?php

namespace Modules\Maps\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class LeafletMap extends Field
{
    protected string $view = 'filament.forms.components.leaflet-map';

    protected string $latField = 'latitude';
    protected string $lngField = 'longitude';
    protected string $zoomField = 'zoom';

    public function latField(string $field): static
    {
        $this->latField = $field;

        return $this;
    }

    public function lngField(string $field): static
    {
        $this->lngField = $field;

        return $this;
    }

    public function zoomField(string $field): static
    {
        $this->zoomField = $field;

        return $this;
    }

    public function getLatField(): string
    {
        return $this->latField;
    }

    public function getLngField(): string
    {
        return $this->lngField;
    }

    public function getZoomField(): string
    {
        return $this->zoomField;
    }
}

