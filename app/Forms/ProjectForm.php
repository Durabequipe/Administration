<?php

namespace App\Forms;

use App\Models\Project;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use RalphJSmit\Tall\Interactive\Forms\Form;

class ProjectForm extends Form
{

    public ?Project $project = null;

    public function getFormSchema(array $params): array
    {
        return [
            Hidden::make('id')
                ->default($this->project?->id),

            TextInput::make('name')
                ->label('Name')
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

        $this->project = $project;
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
