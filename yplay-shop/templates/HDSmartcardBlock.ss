<% include TextBlock %>

<div class="uk-margin">
	<% if Products.exists %>
	<table>
		<% loop Products %>
		<tr>
			<td>$Title</td>
			<td>$printPriceString</td>
		</tr>
		<% end_loop %>
	</table>
		
	<% else %>
	<p><i>Zurzeit keine Produkte verfügbar</i></p>
	<% end_if %>
</div>