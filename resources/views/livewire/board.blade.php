<div>
    <div id="buttons-area">
        <button onclick="save()">Save</button>
        <button onclick="addLink()">Add Link</button>
    </div>
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

        let rect = new joint.shapes.standard.Rectangle();
        rect.position(100, 30);
        rect.resize(100, 40);
        rect.attr({
            video: {
                id: "1234",
            },
            body: {
                fill: "blue",
            },
            label: {
                text: "Hello",
                fill: "white",
            },
        });
        rect.addTo(graph);

        let rect2 = new joint.shapes.standard.Rectangle();
        rect2.position(400, 200);
        rect2.resize(100, 40);
        rect2.attr({
            video: {
                id: "4321",
            },
            body: {
                fill: "blue",
            },
            label: {
                text: "Hello",
                fill: "white",
            },
        });
        rect2.addTo(graph);

        let link = new joint.shapes.standard.Link();
        link.source(rect);
        link.target(rect2);
        link.addTo(graph);


    </script>

    <script>
        function save() {
            window.graph.getElements().forEach((element) => {
                console.log(
                    element.attributes.attrs.video.id,
                    element.attributes.position
                );
            });
        }

        function addLink() {

        }
    </script>


</div>
