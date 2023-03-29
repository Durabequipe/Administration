<?php

namespace App\Filament\Resources\PositionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\PositionResource;

class ListPositions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = PositionResource::class;
}
