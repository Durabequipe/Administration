<div>
    <div class="draggable-area">
        <div style="height: calc(100vh - 4rem);" id="area">
            @foreach($videos as $i => $video)
                @include('includes.Builder.Card', ['video' => $video])
            @endforeach
        </div>
    </div>

    <script type="module">
        window.ds.subscribe("callback", (object) => {
            for (const button of object.items) {
                Livewire.emit('moveCard', button.id, object.event.x - 75, object.event.y - 150);
            }
        });
    </script>
</div>
