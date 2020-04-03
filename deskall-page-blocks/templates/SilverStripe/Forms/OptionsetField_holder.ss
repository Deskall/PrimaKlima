<div id="$HolderID" class="field <% if $extraClass %>$extraClass<% end_if %> uk-margin-small data-la">
	<% if $Title %><label class="uk-form-label" for="$ID">$Title <% if Required || Type == "text password" %>*<% end_if %></label><% end_if %>
	<div class="uk-form-controls">$Field</div>
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><span class="description">$Description</span><% end_if %>
</div>
