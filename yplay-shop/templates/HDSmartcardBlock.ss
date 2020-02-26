<% include TextBlock %>

<div class="uk-margin">
	<% if Products.exists %>
	<table class="uk-table uk-table-small">
		<thead>
			<tr><th>&nbsp;</th><th>Produkt</th><th>Einzelpreis</th><th>Gesamt</th></tr>
		</thead>
		<tbody>
		<% loop Products %>
		<tr>
			<td class="uk-table-shrink"><input type="number" min="0" max="10" class="uk-input uk-form-small" /></td>
			<td class="uk-table-expand">$Title</td>
			<td>$PrintPriceString</td>
		</tr>
		<% end_loop %>
		</tbody>
		<tfoot>
			<tr><td>&nbsp;</td><td>Gesamtpreise</th><th id="total-price"></th></tr>
		</tfoot>
		<tbody>
	</table>
		
	<% else %>
	<p><i>Zurzeit keine Produkte verfügbar</i></p>
	<% end_if %>
</div>