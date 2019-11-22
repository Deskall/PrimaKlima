<div id="$HolderID" class="field<% if extraClass %> $extraClass<% end_if %>">
	
		$Field
		<% if Title.NoHTML != $Title %>
		$Title
		<% else %>
		<label class="right" for="$ID">$Title</label>
		<% end_if %>
		<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
		<% if $Description %><span class="description">$Description</span><% end_if %>
	
</div>
