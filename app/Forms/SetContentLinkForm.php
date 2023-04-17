<?php

namespace App\Forms;

use App\Models\Video;
use Closure;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use Livewire\Component;
use RalphJSmit\Tall\Interactive\Forms\Form;


class SetContentLinkForm extends Form
{
    public static $title = 'Ajouter un lien';

    public string $video1ID;
    public string $video2ID;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('content')
                ->label('Contenu')
                ->required()
        ];
    }

    public function submit(Collection $state, Component $livewire, Closure $forceClose): void
    {
        Video::find($this->video1ID)->adjacents()->detach($this->video2ID);

        Video::find($this->video1ID)->adjacents()->attach($this->video2ID, ['content' => $state->get('content')]);
        $livewire->emit('refreshComponent');
    }

    public function mount(): void
    {
    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(array $eventParams, self $formClass, Component $livewire): void
    {
        $formClass->video1ID = $eventParams[0];
        $formClass->video2ID = $eventParams[1];

        if ($formClass->video1ID && $formClass->video2ID) {
            $video1 = Video::find($formClass->video1ID);
            $content = $video1->adjacents()->where('id', $formClass->video2ID)->first()?->pivot->content;
            $livewire->form->fill([
                'content' => $content
            ]);
        }

    }
}
