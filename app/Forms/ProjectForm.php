<?php

namespace App\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Collection;
use RalphJSmit\Tall\Interactive\Forms\Form;

class ProjectForm extends Form
{

    public $project = null;

    public function getFormSchema(array $params): array
    {
        $project = $params['project'] ?? null;
        return [
            Hidden::make('id')
                ->default($project['id'] ?? null),

            TextInput::make('name')
                ->label('Nom')
                ->default($project['name'] ?? null)
                ->required(),

            Toggle::make('is_active')
                ->label('Actif')
                ->default($project['is_active'] ?? null)
                ->required(),

            TextInput::make('description')
                ->label('Description')
                ->default($project['description'] ?? null)
                ->required(),

            FileUpload::make('cover_image')
                ->label('Cover Image')
                ->default($project['cover_image'] ?? null)
                ->disk('public'),

            FileUpload::make('thumbnail_image')
                ->label('Thumbnail Image')
                ->default($project['thumbnail_image'] ?? null)
                ->disk('images')

        ];
    }

    public function submit(Collection $state)
    {
        $project = auth()->user()->projects()->updateOrCreate([
            'id' => $state['id'] ?? null
        ],
            $state->toArray()
        );

        return redirect()->route('builder.index');
    }

    public function mount(): void
    {

    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(array $eventParams, self $formClass): void
    {

    }
}
