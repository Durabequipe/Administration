@php use App\Forms\SetContentLinkForm; @endphp
<div id="buttons-area">
    <button onclick="save()">Save</button>
    <button onclick="addLink()">Add Link</button>
</div>

<x-tall-interactive::modal
    id="set-content-link"
    :form="SetContentLinkForm::class"
/>

<div id="builder-area" style="width: 100%; height: 90%; background-color: orange">

    @foreach($videos as $video)
        <div
            id="video-{{ $video->id }}"
            data-video-id="{{ $video->id }}"
            data-links="{{ json_encode($video->adjacents->map(fn($adjacent) => [
                 "id"=> $adjacent->id,
                 "content" =>$adjacent->pivot->content,
             ])) }}"
            @class([
                'bg-green-500' => $video->is_main,
                'bg-indigo-50' => !$video->is_main,
                "node video-{{ $video->id }} flex justify-center w-24 h-24 items-center absolute" => true,
            ])
            style="left: {{ $video->position_x }}px; top: {{ $video->position_y }}px;">
            {{ $video->name  }}
        </div>
    @endforeach

</div>


