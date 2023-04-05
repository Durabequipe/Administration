import * as jsPlumbBrowserUI from "@jsplumb/browser-ui";
import {CONNECTION, EVENT_ELEMENT_MOUSE_UP} from "@jsplumb/browser-ui";
import {AnchorLocations} from "@jsplumb/common";
import {BezierConnector} from "@jsplumb/connector-bezier";


const instance = jsPlumbBrowserUI.newInstance({
    container: document.querySelector("#builder-area"),
    dragOptions: {
        containment: "parent",
        containmentPadding: 10
    },
});

instance.importDefaults({
    connector: BezierConnector.type,
    overlays: [
        {type: "Arrow", options: {location: 1}}
    ],
    anchors: [
        AnchorLocations.AutoDefault,
        AnchorLocations.AutoDefault,
        AnchorLocations.AutoDefault,
        AnchorLocations.AutoDefault
    ],
    maxConnections: 4,
});


drawEverything();

instance.bind(CONNECTION, (connection) => {
    Livewire.emit('modal:open', 'set-content-link', connection.source.dataset.videoId, connection.target.dataset.videoId);
});

instance.bind(EVENT_ELEMENT_MOUSE_UP, (element) => {
    console.log(element);
    //search in parent the div with class node
    const parent = element.closest('.node');
    console.log(parent);
    const position = instance.getOffset(parent);
    const id = parent.dataset.videoId;
    if (id !== undefined) {
        console.log(id, position.x, position.y);
        Livewire.emit('moveCard', id, position.x, position.y);
    }
});

/*instance.bind(EVENT_ELEMENT_CLICK, (element) => {
    console.log(element);
    if (element.dataset.videoId !== undefined) {
        Livewire.emit('modal:open', 'edit-video-' + element.dataset.videoId);
    }
});*/


/*window.addEventListener('refresh', _ => {
    window.location.reload();
})*/

//livewire on refresh
Livewire.on('refreshComponent', _ => {
    window.location.reload();
});

function drawEverything() {
    drawEndpoints();
    drawConnections();
}

function drawEndpoints() {
    const videos = document.getElementsByClassName('node');

    for (const video of videos) {
        for (const position of ['Top', 'Right', 'Bottom', 'Left']) {
            instance.addEndpoint(video, {
                endpoint: "Dot",
                anchor: position,
                source: true,
                target: true,
            });
        }
    }
}

function drawConnections() {
    const videos = document.getElementsByClassName('node');

    for (const video of videos) {
        for (const link of JSON.parse(video.dataset.links)) {
            instance.connect({
                source: video,
                target: document.getElementById(`video-${link.id}`),
                overlays: [
                    {type: "Arrow", options: {location: 1}},
                    {
                        type: "Label", options: {
                            label: link.content,
                            location: 0.5,
                            cssClass: "bg-white text-black p-1 rounded z-10",
                        }
                    }
                ],
            });
        }
    }
}
