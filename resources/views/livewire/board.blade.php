<div id="buttons-area">
    <button onclick="save()">Save</button>
    <button onclick="addLink()">Add Link</button>
</div>

<div id="builder-area" style="width: 100%; height: 90%; background-color: orange">

    @foreach($videos as $video)
        <div
            id="video-{{ $video->id }}"
            data-video-id="{{ $video->id }}"
            data-links="{{ json_encode($video->adjacents->map(fn($adjacent) => [
                 "id"=> $adjacent->id,
                 "content" =>$adjacent->pivot->content,
             ])) }}"
            class="node video-{{ $video->id }} flex bg-indigo-50 justify-center w-24 h-24 items-center absolute"
            style="left: {{ $video->position_x }}px; top: {{ $video->position_y }}px;">
            {{ $video->name  }}
        </div>
    @endforeach

</div>


