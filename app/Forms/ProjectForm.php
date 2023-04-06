<?php

namespace App\Forms;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use RalphJSmit\Tall\Interactive\Forms\Form;

class ProjectForm extends Form
{

    public function getFormSchema(array $params): array
    {
        $project = $params['project'] ?? null;
        $id = $project['id'] ?? null;
        $name = $project['name'] ?? null;
        return [
            Hidden::make('id')
                ->default($id),

            TextInput::make('name')
                ->label('Name')
                ->default($name)
                ->required(),

        ];
    }

    public function submit(Collection $state)
    {
        $project = auth()->user()->projects()->updateOrCreate([
            'id' => $state->get('id')
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
