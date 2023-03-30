import DragSelect from "dragselect";

const ds = new DragSelect({
    selectables: document.querySelectorAll('.draggable'),
    area: document.querySelector('.draggable-area'),
});

export {ds};
