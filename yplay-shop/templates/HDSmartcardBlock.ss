<% include TextBlock %>

<div class="uk-margin">
	<% if Products.exists %>
	<table class="uk-table uk-table-small uk-table-divider">
		<thead>
			<tr><th>&nbsp;</th><th>Produkt</th><th>Einzelpreis</th><th>Gesamt</th></tr>
		</thead>
		<tbody>
		<% loop Products %>
		<tr>
			<td><input type="number" min="0" max="10" class="uk-input uk-form-small" /></td>
			<td class="uk-table-expand">$Title</td>
			<td>$PrintPriceString</td>
		</tr>
		<% end_loop %>
		</tbody>
		<tfoot class="uk-background-muted">
			<tr><td colspan="2">&nbsp;</td><td class="uk-text-right">Gesamtpreise</td><td id="total-price"></td></tr>
		</tfoot>
		<tbody>
	</table>
		
	<% else %>
	<p><i>Zurzeit keine Produkte verfügbar</i></p>
	<% end_if %>
</div>