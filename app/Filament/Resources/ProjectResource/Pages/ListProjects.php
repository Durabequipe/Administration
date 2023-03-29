<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ProjectResource;

class ListProjects extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ProjectResource::class;
}
