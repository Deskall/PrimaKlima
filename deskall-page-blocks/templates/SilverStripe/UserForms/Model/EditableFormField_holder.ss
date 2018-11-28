<div id="$HolderID" class="uk-clearfix field<% if $extraClass %> $extraClass<% end_if %> uk-margin-small">
	<% if $Title %><label class="uk-form-label" for="$ID">$Title <% if Required %>*<% end_if %></label><% end_if %>
	<div class="uk-form-controls">$Field
		<% if $Message %><div class="uk-margin uk-text-small"><span class="message $MessageType">$Message</span></div><% end_if %>
		<% if $Description %><div class="uk-margin uk-text-small"<span class="description">$Description</span></div><% end_if %>
	</div>
	
</div>
