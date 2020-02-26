<% include TextBlock %>

<div class="uk-margin">
	<% if Products.exists %>
		<% loop Products %>
		<div>$Title</div>
		<% end_loop %>
	<% else %>
	<p><i>Zurzeit keine Produkte verfügbar</i></p>
	<% end_if %>
</div>