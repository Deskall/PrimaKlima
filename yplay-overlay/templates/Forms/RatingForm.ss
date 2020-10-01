<% if MessageType == "success" %>
$Message
<% else %>
<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<label class="uk-margin-small">Bewertung *</label>
    <div class="uk-flex uk-flex-left uk-flex-middle">
    	<div class="rating"></div>
    	<div class="rate" hidden></div>
    </div>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>

	<fieldset>
		<% if $Legend %><legend>$Legend</legend><% end_if %>
		<% loop $Fields %>
			$FieldHolder
		<% end_loop %>
		<div class="clear"><!-- --></div>
	</fieldset>

	<% if $Actions %>
	<div class="btn-toolbar">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
<% end_if %>