<div id="$HolderID" class="field<% if extraClass %> $extraClass<% end_if %>">
	<div class="uk-form-controls">
		$Field
		<label class="right <% if Title.NoHTML != $Title %>acceptance<% end_if %>" for="$ID">$Title</label>
		<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
		<% if $Description %><span class="description">$Description</span><% end_if %>
	</div>
</div>
