<div id="builder-area" class="absolute w-[15000px] h-[15000px] z-10">

    @foreach($project->videos as $video)
        <div
            id="video-{{ $video->id }}"
            data-video-id="{{ $video->id }}"
            data-links="{{ json_encode($video->adjacents->map(fn($adjacent) => [
                 "id"=> $adjacent->id,
                 "content" => str($adjacent->pivot->content)->limit(20),
             ])) }}"
            @class([
                'bg-green-500' => $video->is_main,
                'bg-indigo-200' => !$video->is_main,
                "node video-{{ $video->id }} flex justify-center w-48 items-center absolute" => true,
            ])
            style="left: {{ $video->position_x }}px; top: {{ $video->position_y }}px;">
            <div class="relative">
                <a class="absolute top-0 right-0 p-2 z-[999]"
                   onclick="Livewire.emit('modal:open', 'video-form', '{{ $video->id }}')">
                    <i class="fas fa-pen text-white"></i>
                </a>
                <img src="{{ $video->desktopThumbnail }}" alt="{{ $video->name }}" class="w-full h-auto object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-1 pb-2">
                    <h2 @class([
                            'underline' => $video->is_main,
                            'text-white',
                            'text-xl',
                            'font-bold',
                            'text-center',

]                       )>{{ $video->name }}</h2>

                </div>
            </div>

        </div>

    @endforeach

</div>

<div id="buttons-area" class="z-[999] fixed right-10 bottom-10 justify-center">
    <div class="w-48 h-16 bg-indigo-100 flex justify-around rounded-3xl ">
        <button id="save" class="p-2 border m-2" onclick="Livewire.emit('modal:open', 'video-form', null)">
            Ajouter une vidéo
        </button>
    </div>
</div>
