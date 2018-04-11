<nav class="dk-step-navigation">
	<ul class="dk-step-buttons">

		<% if $Actions %>
		<li class="step-button-wrapper Actions">
		<% loop $Actions %>
			$Field
		<% end_loop %>
		</li>
		<% end_if %>

	</ul>
</nav>