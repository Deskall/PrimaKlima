<div id="$HolderID" class="field <% if $extraClass %>$extraClass<% end_if %> uk-margin-small">
	<% if $Title %><label class="uk-form-label" for="$ID">$Title <% if Required || Type == "text password" %>*<% end_if %></label><% end_if %>
	<div class="uk-form-controls">
		<ul $AttributesHTML>
	
		<% loop $Options %>
			<li class="$Class">
				<input id="$ID" class="radio uk-radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
				<label for="$ID">$Title</label>
			</li>
		<% end_loop %>
		</ul>
	</div>
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><span class="description">$Description</span><% end_if %>
</div>