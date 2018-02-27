<div id="$HolderID" class="field<% if $extraClass %> $extraClass<% end_if %> uk-form-controls uk-margin-small">
	<% if $Title %><label class="uk-form-label" for="$ID">$Title</label><% end_if %>
	$Field
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><span class="description">$Description</span><% end_if %>
</div>
