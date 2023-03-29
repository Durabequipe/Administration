<?php

namespace App\Filament\Resources\InteractResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\InteractResource;

class ListInteracts extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = InteractResource::class;
}
