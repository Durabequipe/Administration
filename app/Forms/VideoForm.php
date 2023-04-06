<?php

namespace App\Forms;

use App\Models\Video;
use App\Services\VideoService;
use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use RalphJSmit\Tall\Interactive\Forms\Form;

class VideoForm extends Form
{
    public ?Video $video = null;

    public function getFormSchema(array $params): array
    {
        return [
            Hidden::make('project_id')
                ->default($params['project']['id']),

            TextInput::make('name')
                ->label('Nom')
                ->string()
                ->maxLength(255)
                ->required()
                ->columnSpan(12),


            FileUpload::make('desktop_path')
                ->required()
                ->placeholder('Desktop video path')
                ->disk('videos')
                ->default($params['video']['desktop_path'] ?? '')
                ->reactive()
                ->afterStateUpdated(function (Closure $set, TemporaryUploadedFile $state, VideoService $videoService) {
                    $path = $videoService->generateThumbnailFromPath($state->getRealPath());
                    $set('desktop_thumbnail', $path);
                })
                ->columnSpan(12),

            Hidden::make('desktop_thumbnail'),


            Toggle::make('is_main')
                ->rules(['boolean'])
                ->default('false')
                ->default($params['video']['is_main'] ?? '')
                ->columnSpan(12),

            TextInput::make('interaction_title')
                ->label('Titre de l\'intéraction')
                ->string()
                ->maxLength(255)
                ->required()
                ->columnSpan(12),


        ];
    }

    public function submit(Collection $state, Component $livewire, VideoService $service): void
    {
        $video = Video::updateOrCreate([
            'id' => $this->video->id ?? null,
        ], $state->toArray());

        $service->generateThumbnail($video);

        $livewire->emit('refreshComponent', 'Video saved!');
    }

    public function mount(): void
    {
    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(array $eventParams, self $formClass): void
    {
        if (isset($eventParams[0]['video'])) {
            $formClass->video = Video::find($eventParams[0]['video']);
        }
    }
}
