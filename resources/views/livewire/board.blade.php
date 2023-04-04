
<div id="builder-area" class="absolute w-screen h-screen bg-indigo-50">

    @foreach($project->videos as $video)
        <div
            id="video-{{ $video->id }}"
            data-video-id="{{ $video->id }}"
            data-links="{{ json_encode($video->adjacents->map(fn($adjacent) => [
                 "id"=> $adjacent->id,
                 "content" =>$adjacent->pivot->content,
             ])) }}"
            @class([
                'bg-green-500' => $video->is_main,
                'bg-indigo-200' => !$video->is_main,
                "node video-{{ $video->id }} flex justify-center w-24 h-24 items-center absolute" => true,
            ])
            style="left: {{ $video->position_x }}px; top: {{ $video->position_y }}px;">
            {{ $video->name  }}
        </div>
    @endforeach


    <div id="buttons-area" class="fixed flex bottom-10 w-screen justify-center">
        <div class="w-48 h-16 bg-indigo-100 flex justify-around rounded-3xl ">
            <button id="save" class="p-2 border m-2" onclick="Livewire.emit('modal:open', 'video-form')">
                Ajouter une vidéo
            </button>
        </div>

    </div>

</div>

