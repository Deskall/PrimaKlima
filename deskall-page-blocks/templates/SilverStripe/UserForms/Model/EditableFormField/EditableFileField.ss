<div data-uk-form-custom="target:true">
<button type="button" class="uk-button uk-button-primary" tabindex="-1" ><%t Form.SelectFile 'Datei auswählen' %></button>
<input type="hidden" name="MAX_FILE_SIZE" value="$MaxFileSize" />
<input $AttributesHTML<% if $RightTitle %> aria-describedby="{$Name}_right_title"<% end_if %>/>
</div>

 <div data-uk-form-custom="target: true">
    <input type="file">
    <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
 </div>
  