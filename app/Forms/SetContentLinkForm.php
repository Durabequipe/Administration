<?php

namespace App\Forms;

use App\Models\Video;
use App\Services\VideoService;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Livewire\Component;
use RalphJSmit\Tall\Interactive\Actions\ButtonAction;
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
    public function onOpen(array $eventParams, self $formClass, Component $livewire, VideoService $videoService, $forceClose): void
    {
        $formClass->video1ID = $eventParams[0];
        $formClass->video2ID = $eventParams[1];

        $video1 = Video::find($formClass->video1ID);
        $video2 = Video::find($formClass->video2ID);

        if (!$videoService->ensureNotRecursive($video1, $video2)) {

            Notification::make()
                ->title('Erreur')
                ->body('Impossible de créer un lien récursif')
                ->danger()
                ->send();

            sleep(1);
            $livewire->emit('refreshComponent');


            return;
        }

        if ($video1 && $video2) {
            $content = $video1->adjacents()->where('id', $video2->id)->first()?->pivot->content;
            $livewire->form->fill([
                'content' => $content
            ]);
        }

    }

    public function getButtonActions()
    {
        return [
            ButtonAction::make('delete')
                ->label('Supprimer')
                ->color('danger')
                ->action(function (Component $livewire) {
                    Video::find($this->video1ID)->adjacents()->detach($this->video2ID);
                    $livewire->emit('refreshComponent');
                }),
        ];
    }
}
