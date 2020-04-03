<fieldset id="$Name" data-la class="field<% if $extraClass %> $extraClass<% end_if %>"<% if $RightTitle %> aria-describedby="{$Name}_right_title"<% end_if %>>
	<% if $Title %><legend class="left">$Title</legend><% end_if %>

	<div class="middleColumn">
		$Field
	</div>

	<% if $RightTitle %><span id="{$Name}_right_title" class="right-title">$RightTitle</span><% end_if %>
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
</fieldset>

<div id="$Name" class="field <% if $extraClass %>$extraClass<% end_if %> uk-margin-small" <% if $RightTitle %> aria-describedby="{$Name}_right_title"<% end_if %>>
	<% if $Title %><label class="uk-form-label" for="$ID">$Title <% if Required || Type == "text password" %>*<% end_if %></label><% end_if %>
	<div class="uk-form-controls">$Field</div>
	<% if $RightTitle %><span id="{$Name}_right_title" class="right-title">$RightTitle</span><% end_if %>
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
</div>
