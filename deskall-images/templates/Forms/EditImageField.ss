<button id="edit-image" data-id="$ID"><%t Image.Edit 'Bild bearbeiten' %></button>

<div id="tui-image-editor"></div>
var instance = new ImageEditor(document.querySelector('#tui-image-editor'), {
    cssMaxWidth: 700,
    cssMaxHeight: 500,
    selectionStyle: {
        cornerSize: 20,
        rotatingPointOffset: 70
    }
});