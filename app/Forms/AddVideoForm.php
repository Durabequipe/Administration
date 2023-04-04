<?php

namespace App\Forms;

use App\Models\Video;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Collection;
use RalphJSmit\Tall\Interactive\Forms\Form;

class AddVideoForm extends Form
{
    public static string $title = 'Ajouter une vidéo';

    public function getFormSchema(array $params): array
    {
        return [

            Hidden::make('project_id')
                ->default($params['project']['id']),

            TextInput::make('name')
                ->rules(['max:255', 'string'])
                ->placeholder('Name')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),
            FileUpload::make('desktop_path')
                ->required()
                ->placeholder('Desktop video path')
                ->disk('videos')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            FileUpload::make('desktop_thumbnail')
                ->rules(['image', 'max:1024'])
                ->image()
                ->placeholder('Desktop Thumbnail')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            FileUpload::make('mobile_path')
                ->placeholder('Mobile video path')
                ->disk('videos')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            FileUpload::make('mobile_thumbnail')
                ->rules(['image', 'max:1024'])
                ->image()
                ->placeholder('Mobile Thumbnail')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            Toggle::make('is_main')
                ->rules(['boolean'])
                ->default('false')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            TextInput::make('interaction_title')
                ->label('Interaction Title')
                ->rules(['max:255', 'string'])
                ->placeholder('Interaction Title')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),


        ];
    }

    public function submit(Collection $state): void
    {
        Video::create($state->toArray());
    }

    public function mount(): void
    {
    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(array $eventParams, self $formClass): void
    {
    }
}
