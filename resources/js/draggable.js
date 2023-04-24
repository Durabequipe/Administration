const plumbBoard = document.getElementById('builder-area');

plumbBoard.addEventListener('mousedown', startDrag);

let mouseOffsetX;
let mouseOffsetY;
let plumbBoardOffsetLeft;
let plumbBoardOffsetTop;

function startDrag(event) {
    if (event.target.closest('.node') !== null || event.target.tagName === "circle") return;
    mouseOffsetX = event.clientX - plumbBoard.offsetLeft;
    mouseOffsetY = event.clientY - plumbBoard.offsetTop;
    plumbBoardOffsetLeft = plumbBoard.offsetLeft;
    plumbBoardOffsetTop = plumbBoard.offsetTop;

    // Ajoutez des gestionnaires d'événements pour les événements "mousemove" et "mouseup"
    document.addEventListener('mousemove', doDrag);
    document.addEventListener('mouseup', stopDrag);
}

function doDrag(event) {
    const newLeft = event.clientX - mouseOffsetX;
    const newTop = event.clientY - mouseOffsetY;
    plumbBoard.style.left = newLeft + 'px';
    plumbBoard.style.top = newTop + 'px';
}

function stopDrag(event) {
    document.removeEventListener('mousemove', doDrag);
    document.removeEventListener('mouseup', stopDrag);
}
