<div id="$HolderID" class="field<% if extraClass %> $extraClass<% end_if %>">
	<div class="uk-form-controls">
		<div class="uk-flex uk-flex-left">
		$Field
		<label class="right" for="$ID">$Title</label>
		</div>
		<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
		<% if $Description %><span class="description">$Description</span><% end_if %>
	</div>
</div>
