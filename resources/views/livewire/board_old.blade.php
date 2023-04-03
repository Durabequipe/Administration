@php use App\Forms\UserForm; @endphp
<div>
    <div id="buttons-area">
        <button onclick="save()">Save</button>
        <button onclick="addLink()">Add Link</button>
    </div>
    <x-tall-interactive::modal
        id="create-user"
        :form="UserForm::class"
    />
    <button onclick="openModal('create-user')" type="button" class="">
        Open Modal
    </button>
    <div id="builder-area"></div>
    <script type="module">
        let joint = window.joint;
        let namespace = joint.shapes;
        console.log(namespace);

        let graph = new joint.dia.Graph({}, {cellNamespace: namespace});
        window.graph = graph;

        let paper = new joint.dia.Paper({
            el: document.getElementById("builder-area"),
            model: graph,
            width: window.innerWidth,
            height: window.innerHeight,
            gridSize: 10,
            cellViewNamespace: namespace,
            drawGrid: true,
            background: {
                color: "rgba(255, 0, 0, 0.1)",
            },
        });

        @foreach($videos as $video)
        new joint.shapes.standard.Rectangle()
            .position({{ $video->position_x  }}, {{ $video->position_y }})
            .resize(100, 40)
            .attr({
                video: {
                    id: "{{$video->id}}",
                },
                links: @json($video->adjacents->map(fn($adjacent) => [
                            "id"=> $adjacent->id,
                            "content" =>$adjacent->pivot->content,
                        ])),
                body: {
                    fill: "blue",
                },
                label: {
                    text: "{{$video->name}}",
                    fill: "white",
                },
            })
            .addTo(graph);
        @endforeach

        graph.getElements().forEach((element) => {
            element.attributes.attrs.links.forEach((link) => {
                let linkElement = new joint.shapes.standard.Link();
                linkElement.source(element);
                linkElement.target(getElementByVideoID(link.id));

                linkElement.appendLabel({
                    attrs: {
                        text: {
                            text: link.content,
                        }
                    },
                });
                linkElement.addTo(graph);
            });
        });


        paper.on('link:pointerdblclick', function (link) {
            console.log(link);
            window.livewire.emit('modal:open', 'create-user');
        });


    </script>

    <script>
        async function save() {
            window.graph.getElements().forEach((element) => {
                console.log(
                    element.attributes.attrs.video.id,
                    element.attributes.position,
                    element.attributes
                );
                window.livewire.emit('moveCard', element.attributes.attrs.video.id, element.attributes.position.x, element.attributes.position.y)

            });

            await refresh();
        }

        async function addLink() {
            console.log("Waiting for click...");
            await waitForClick();
            let click2 = await waitForClick();
            let click3 = await waitForClick();

            let video1 = window.graph.getCell(click2.target.parentNode.getAttribute('model-id'));
            let video2 = window.graph.getCell(click3.target.parentNode.getAttribute('model-id'));

            let video1ID = video1.attributes.attrs.video.id;
            let video2ID = video2.attributes.attrs.video.id;

            await window.livewire.emit('addLink', video1ID, video2ID);

            await refresh();
        }

        async function delay(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function refresh() {
            await delay(200);
            window.location.reload();
        }

        async function waitForClick() {
            return new Promise(resolve => {
                document.addEventListener('click', function onClick(event) {
                    document.removeEventListener('click', onClick);
                    resolve(event);
                });
            });
        }


        function getElementByVideoID(videoID) {
            return window.graph.getElements().find((element) => {
                return element.attributes.attrs.video.id === videoID;
            });
        }

        function getTextRelationBetweenVideos(video1, video2) {
            console.log("video1" + video1, "video2" + video2);
        }
    </script>


    <script>
        function openModal(modalId) {
            console.log(modalId);
            window.livewire.emit('modal:open', modalId);
            console.log("open");
        }
    </script>

</div>
