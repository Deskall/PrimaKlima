<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<div class="uk-grid-small" data-uk-grid>
		<div class="uk-width-1-1">
		   	<h2>Kursanmeldung</h2>
		    <div><p>Die Online-Anmeldung ist verbindlich.</p></div>
		    <div><p><small>* = Pflichtfeld.</small></p></div>
		</div>
		<% loop $Fields %>
			<% if Name == "FirstPerson" %>
			<fieldset class="uk-width-1-2@s">
				<legend><h3>Ihre Angaben</h3></legend>
					$FieldHolder
			</fieldset>
			<% else %>
			$FieldHolder
			<% end_if %>
		<% end_loop %>
	</div>
	<% if $Actions %>
	<div class="btn-toolbar uk-text-right uk-margin">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>