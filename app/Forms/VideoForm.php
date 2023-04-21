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
use RalphJSmit\Tall\Interactive\Actions\ButtonAction;
use RalphJSmit\Tall\Interactive\Forms\Form;

class VideoForm extends Form
{
    public $video = null;

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
                ->reactive()
                ->afterStateUpdated(function (Closure $set, TemporaryUploadedFile $state, VideoService $videoService) {
                    $path = $videoService->generateThumbnailFromPath($state->getRealPath());
                    $set('desktop_thumbnail', $path);
                })
                ->columnSpan(12),

            Hidden::make('desktop_thumbnail'),

            FileUpload::make('mobile_path')
                ->placeholder('Mobile video path')
                ->disk('videos')
                ->reactive()
                ->afterStateUpdated(function (Closure $set, TemporaryUploadedFile $state, VideoService $videoService) {
                    $path = $videoService->generateThumbnailFromPath($state->getRealPath());
                    $set('mobile_thumbnail', $path);
                })
                ->columnSpan(12),

            Hidden::make('mobile_thumbnail'),

            Toggle::make('is_main')
                ->rules(['boolean'])
                ->default($params['video']['is_main'] ?? false)
                ->columnSpan(12),

            Toggle::make('can_choose_theme')
                ->rules(['boolean'])
                ->default($params['video']['can_choose_theme'] ?? false)
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
            'id' => $this->video['id'] ?? null,
        ], $state->toArray() + [
                'position_x' => 100,
                'position_y' => 200,
            ]);

        $service->generateThumbnail($video);

        $livewire->emit('refreshComponent', 'Video saved!');
    }

    public function mount(): void
    {
    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(array $eventParams, self $formClass, Component $livewire, $params): void
    {
        if ($eventParams[0] != null) {
            $formClass->video = Video::find($eventParams[0]);

            $datas = $formClass->fill($params);
        } else {
            $formClass->video = null;
            $datas = [
                'project_id' => $params['project']['id'],
            ];
        }
        $livewire->form->fill($datas);

    }

    public function fill($params): array
    {
        if (!$this->video)
            return [
                'project_id' => $params['project']['id'],
            ];

        return [
            'name' => $this->video['name'],
            'desktop_path' => is_array($this->video) ? $this->video['desktop_path'] : $this->video->getAttributes()['desktop_path'],
            'desktop_thumbnail' => is_array($this->video) ? $this->video['desktop_thumbnail'] : $this->video->getAttributes()['desktop_thumbnail'],
            'mobile_path' => is_array($this->video) ? $this->video['mobile_path'] : $this->video->getAttributes()['mobile_path'],
            'mobile_thumbnail' => is_array($this->video) ? $this->video['mobile_thumbnail'] : $this->video->getAttributes()['mobile_thumbnail'],
            'is_main' => $this->video['is_main'],
            'interaction_title' => $this->video['interaction_title'],
            'project_id' => $this->video['project_id'],
        ];
    }

    public function getButtonActions(): array
    {
        return [
            ButtonAction::make('delete')
                ->label('Supprimer')
                ->color('danger')
                ->action(function (Component $livewire) {
                    Video::find($this->video['id'])->delete();
                    $livewire->emit('refreshComponent', 'Video deleted!');
                })
                ->visible(fn() => $this->video['id'] ?? false),
        ];
    }
}
