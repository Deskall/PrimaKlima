<% if $Actions %>
<nav class="Actions uk-navbar uk-margin">
	<div class="uk-navbar-right">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
</nav>
<% end_if %>