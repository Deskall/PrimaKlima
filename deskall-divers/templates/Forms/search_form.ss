<form $AttributesHTML>
	<div class="uk-margin-remove uk-margin-small" data-uk-grid>
		<% loop $Fields %>
			$Field
		<% end_loop %>
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
</form>