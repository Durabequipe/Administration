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


instance.bind(CONNECTION, (params) => {
    Livewire.emit('addLink', params.source.dataset.videoId, params.target.dataset.videoId);
});

instance.bind(EVENT_ELEMENT_MOUSE_UP, (element) => {
    const position = instance.getOffset(element);
    const id = element.dataset.videoId;
    Livewire.emit('moveCard', id, position.x, position.y);
});
