<div id="unknown-dose-form" <% if not Message %>hidden<% end_if %> class="uk-margin">
	<div class="uk-width-3-4 uk-align-center">
		<% if $IncludeFormTag %>
		<form $AttributesHTML>
		<% end_if %>
			<% if $Message %>
			<p id="{$FormName}_error" class="message $MessageType">$Message</p>
			<% else %>
			<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
			<% end_if %>
			<div class="uk-child-width-1-1" data-uk-grid>
				<% if $Legend %><legend>$Legend</legend><% end_if %>
				<% loop $Fields %>
					$FieldHolder
				<% end_loop %>
				<div class="clear"><!-- --></div>
			</div>
			<% if $Actions %>
			<div class="btn-toolbar uk-text-center">
				<% loop $Actions %>
					$Field
				<% end_loop %>
			</div>
			<% end_if %>
		<% if $IncludeFormTag %>
		</form>
		<% end_if %>
	</div>
</div>
