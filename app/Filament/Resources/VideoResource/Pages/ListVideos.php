<?php

namespace App\Filament\Resources\VideoResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\VideoResource;
use App\Filament\Traits\HasDescendingOrder;

class ListVideos extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = VideoResource::class;
}
