<x-filament::page>
    <div id="area" class="border" style="width: 100%; height: 100%;">
        <div class="bg-red-400">
            @for($i=0; $i<10; $i++)
                @include('includes.Builder.Card', ['title' => 'Card '. $i, 'id' => $i])
            @endfor
        </div>
    </div>

</x-filament::page>

<script type="module">
    import DragSelect from "https://unpkg.com/dragselect@latest/dist/ds.es6m.min.js";

    const ds = new DragSelect({
        selectables: document.querySelectorAll(".item"),
        area: document.querySelector('#area'),
    });

    ds.subscribe("callback", (object) => {
        for (const button of object.items) {
            console.log(object);

            console.log(
                "Button " + button.id + " moved to :",
                object.event.x,
                object.event.y
            );
        }
    });


</script>
