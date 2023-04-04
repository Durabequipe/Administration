<?php

namespace App\Forms;

use App\Models\Video;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use RalphJSmit\Tall\Interactive\Forms\Form;

class SetContentLinkForm extends Form
{
    public static $title = 'Ajouter un lien';

    public array $video1;
    public array $video2;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('content')
                ->label('Contenu')
                ->required()
        ];
    }

    public function submit(Collection $state): void
    {
        Video::find($this->video1['id'])->adjacents()->attach($this->video2['id'], ['content' => $state->get('content')]);
    }

    public function mount(): void
    {
    }

    /** Only applicable for Modals and SlideOvers */
    public function onOpen(array $eventParams, self $formClass): void
    {
        $this->video1 = $eventParams[0]['video1'];
        $this->video2 = $eventParams[0]['video2'];
    }
}
