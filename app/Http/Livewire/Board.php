<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class Board extends Component
{
    public $project = null;
    public $videos = [];

    protected $listeners = [
        'moveCard' => 'moveCard',
        'addLink' => 'addLink',
        'addVideo' => 'addVideo'
    ];

    public function mount()
    {
        $this->videos = $this->project->videos;
    }

    public function render()
    {
        return view('livewire.board');
    }

    public function moveCard(Video $video, $positionX, $positionY)
    {
        $video->update([
            'position_x' => $positionX,
            'position_y' => $positionY,
        ]);

        $this->emit('refreshComponent');
    }

}
