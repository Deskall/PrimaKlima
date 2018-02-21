<% if $Actions %>
<nav class="Actions uk-navbar uk-navbar-right uk-margin">
	<% loop $Actions %>
		$Field
	<% end_loop %>
</nav>
<% end_if %>