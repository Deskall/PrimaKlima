<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<div class="uk-child-width-1-1 data-uk-grid>
		
			<div class="uk-card uk-card-default uk-card-body ">
			<% with Fields.FieldByName('Logo') %>
			$FieldHolder
			<% end_with %>
			</div>
		
			<div class="uk-card uk-card-default uk-card-body ">
			<% with Fields.FieldByName('OnlineFields') %>
			$FieldHolder
			<% end_with %>
			</div>
	</div>

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
