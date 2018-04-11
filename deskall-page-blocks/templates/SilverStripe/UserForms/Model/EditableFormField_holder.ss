<div id="$HolderID" class="field<% if $extraClass %> $extraClass<% end_if %> $ClassName uk-form-controls uk-margin-small">
	<% if $Title && $Parent.ShowLabels %><label class="uk-form-label" for="$ID">$Title</label><% end_if %>
	$Field
	$Parent.ClassName
	$ParentID
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><span class="description">$Description</span><% end_if %>
</div>
