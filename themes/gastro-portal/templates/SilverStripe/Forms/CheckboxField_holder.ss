<div id="$HolderID" class="field<% if extraClass %> $extraClass<% end_if %>">
	<div class="uk-flex-inline uk-flex-top">
		<div>$Field</div>
		<div>
			<% if Title.NoHTML != $Title %>
			<label class="right" for="$ID">$Title</label>
			<% else %>
			<label class="right" for="$ID">$Title</label>
			<% end_if %>
		</div>
		<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
		<% if $Description %><span class="description">$Description</span><% end_if %>
	</div>
</div>
