<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class Board extends Component
{
    public $videos = [];
    protected $listeners = ['moveCard' => 'moveCard', 'addLink' => 'addLink'];

    public function mount()
    {
        $this->videos = Video::all();
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

        $this->videos = Video::all();
    }

    public function addLink(Video $video1, Video $video2)
    {
        $video1->adjacents()->attach($video2);

        $this->videos = Video::all();
    }
}
