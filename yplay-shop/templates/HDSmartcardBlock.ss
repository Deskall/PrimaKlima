<% include TextBlock %>

<div class="uk-margin">
	<% if Products.exists %>
		<% loop Products %>
		<% end_loop %>
	<% else %>
	<p>Zurzeit keine Produkte verfügbar</p>
	<% end_if %>
</div>