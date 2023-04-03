import * as jsPlumbBrowserUI from "@jsplumb/browser-ui";
import {CONNECTION, EVENT_ELEMENT_MOUSE_UP} from "@jsplumb/browser-ui";
import {AnchorLocations} from "@jsplumb/common";


const instance = jsPlumbBrowserUI.newInstance({
    container: document.querySelector("#builder-area"),
    dragOptions: {
        containment: "parent",
        containmentPadding: 10
    },
    connectionsDetachable: false
});

instance.importDefaults({
    //connector: FlowchartConnector.type,
    overlays: [
        {type: "Arrow", options: {location: 1}}
    ],
    maxConnections: 4,
    anchor: AnchorLocations.AutoDefault,

});


const videos = document.getElementsByClassName('node');

for (const video of videos) {
    for (const position of ['Top', 'Right', 'Bottom', 'Left']) {
        instance.addEndpoint(video, {
            endpoint: "Dot",
            anchor: AnchorLocations.AutoDefault,
            source: true,
            target: true,
        });
    }
}

for (const video of videos) {
    for (const link of JSON.parse(video.dataset.links)) {
        instance.connect({
            source: video,
            target: document.getElementById(`video-${link.id}`),
            overlays: [
                {type: "Arrow", options: {location: 1}}
            ],

        });
    }
}


instance.bind(CONNECTION, (params) => {
    Livewire.emit('addLink', params.source.dataset.videoId, params.target.dataset.videoId);
});

instance.bind(EVENT_ELEMENT_MOUSE_UP, (element) => {
    const position = instance.getOffset(element);
    const id = element.dataset.videoId;
    Livewire.emit('moveCard', id, position.x, position.y);
});
