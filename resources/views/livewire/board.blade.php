<div id="builder-area" class="absolute w-screen h-screen z-10">

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
                "node video-{{ $video->id }} flex justify-center w-48 items-center absolute" => true,
            ])
            style="left: {{ $video->position_x }}px; top: {{ $video->position_y }}px;">
            <div class="relative">
                <img src="{{ $video->desktopThumbnail }}" alt="{{ $video->name }}" class="w-full h-auto object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                <div class="absolute inset-x-0 bottom-0 p-1 pb-2">
                    <h2 class="text-white text-xl font-bold text-center">{{ $video->name }}</h2>
                    <p class="text-white text-sm text-center p-0">{{ $video->interaction_title }}</p>
                </div>
            </div>
        </div>
    @endforeach


    <div id="buttons-area" class="z-[999] fixed flex bottom-10 w-screen justify-center">
        <div class="w-48 h-16 bg-indigo-100 flex justify-around rounded-3xl ">
            <button id="save" class="p-2 border m-2" onclick="Livewire.emit('modal:open', 'video-form')">
                Ajouter une vidéo
            </button>
        </div>
    </div>

</div>

