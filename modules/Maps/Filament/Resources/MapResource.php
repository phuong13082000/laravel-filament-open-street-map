<?php

namespace Modules\Maps\Filament\Resources;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Maps\Filament\Forms\Components\LeafletMap;
use Modules\Maps\Filament\Resources\MapResource\Pages\CreateMap;
use Modules\Maps\Filament\Resources\MapResource\Pages\EditMap;
use Modules\Maps\Filament\Resources\MapResource\Pages\ListMaps;
use Modules\Maps\Models\Map;
use BackedEnum;
use Modules\Maps\Services\MapService;
use UnitEnum;

class MapResource extends Resource
{
    protected static ?string $model = Map::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-map';

    protected static string|UnitEnum|null $navigationGroup = 'Maps';

    public static function form(Schema $schema): Schema
    {
        $defaults = app(MapService::class)->defaultCenter();

        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                LeafletMap::make('map_state')
                    ->label('Map')
                    ->default($defaults)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('Lat')
                    ->sortable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->label('Lng')
                    ->sortable(),
                Tables\Columns\TextColumn::make('zoom')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaps::route('/'),
            'create' => CreateMap::route('/create'),
            'edit' => EditMap::route('/{record}/edit'),
        ];
    }
}

