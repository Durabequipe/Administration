<?php

namespace App\Filament\Resources\InteractionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\InteractionResource;

class ListInteractions extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = InteractionResource::class;
}
