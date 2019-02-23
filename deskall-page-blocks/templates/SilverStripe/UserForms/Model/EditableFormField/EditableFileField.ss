
	       <div uk-form-custom="target: true">
	           <input type="file">
	           <input class="uk-input uk-form-width-medium" type="text" placeholder="<%t Form.SelectFile 'Datei auswählen' %>" disabled>
	           <input type="hidden" name="MAX_FILE_SIZE" value="$MaxFileSize" />
	           <input $AttributesHTML<% if $RightTitle %> aria-describedby="{$Name}_right_title"<% end_if %>/>
	       </div>
	   