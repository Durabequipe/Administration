<div>
    <div class="draggable-area">
        <div style="height: calc(100vh - 4rem);" id="area">
            @foreach($videos as $i => $video)
                @include('includes.Builder.Card', ['title' => $video->name, 'id' => $video->id])
            @endforeach
        </div>
    </div>

    <script type="module">
        window.ds.subscribe("callback", (object) => {
            for (const button of object.items) {
                console.log(object);
                console.log(
                    "Button " + button.id + " moved to :",
                    object.event.x,
                    object.event.y
                );

                Livewire.emit('moveCard', button.id, object.event.x, object.event.y);
            }
        });
    </script>
</div>
