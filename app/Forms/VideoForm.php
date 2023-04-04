<?php

namespace App\Forms;

use App\Models\Video;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Collection;
use Livewire\Component;
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
                ->rules(['max:255', 'string'])
                ->placeholder('Name')
                ->default($params['video']['name'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),
            FileUpload::make('desktop_path')
                ->required()
                ->placeholder('Desktop video path')
                ->disk('videos')
                ->default($params['video']['desktop_path'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            FileUpload::make('desktop_thumbnail')
                ->rules(['image', 'max:1024'])
                ->image()
                ->placeholder('Desktop Thumbnail')
                ->default($params['video']['desktop_thumbnail'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            FileUpload::make('mobile_path')
                ->placeholder('Mobile video path')
                ->disk('videos')
                ->default($params['video']['mobile_path'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            FileUpload::make('mobile_thumbnail')
                ->rules(['image', 'max:1024'])
                ->image()
                ->placeholder('Mobile Thumbnail')
                ->default($params['video']['mobile_thumbnail'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            Toggle::make('is_main')
                ->rules(['boolean'])
                ->default('false')
                ->default($params['video']['is_main'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            TextInput::make('interaction_title')
                ->label('Interaction Title')
                ->rules(['max:255', 'string'])
                ->placeholder('Interaction Title')
                ->default($params['video']['interaction_title'] ?? '')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),


        ];
    }

    public function submit(Collection $state, Component $livewire): void
    {
        Video::updateOrCreate([
            'id' => $this->video->id ?? null,
        ], $state->toArray());

        $livewire->emit('refresh', 'Video saved!');
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
