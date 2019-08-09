<div id="$HolderID" class="field <% if $extraClass %>$extraClass<% end_if %> uk-margin-small">
	<div class="uk-form-controls"><button id="edit-image" data-id="$ID"><%t Image.Edit 'Bild bearbeiten' %></button></div>
</div>


<div id="tui-image-editor"></div>
<script>
	var instance = new ImageEditor(document.querySelector('#tui-image-editor'), {
    cssMaxWidth: 700,
    cssMaxHeight: 500,
    selectionStyle: {
        cornerSize: 20,
        rotatingPointOffset: 70
    }
});
</script>