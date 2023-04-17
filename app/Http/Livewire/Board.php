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
        'addVideo' => 'addVideo',
        'deleteLink' => 'deleteLink',
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

    public function deleteLink($videoId1, $videoId2)
    {
        $video1 = Video::find($videoId1);
        $video2 = Video::find($videoId2);

        dd($video1, $video2);
    }

}
