<% include TextBlock %>

<div class="uk-margin">
	<% if Products.exists %>
	<table class="uk-table uk-table-small uk-table-divider">
		<thead>
			<tr><th>&nbsp;</th><th>Produkt</th><th>Einzelpreis</th><th class="uk-text-right">Gesamt</th></tr>
		</thead>
		<tbody>
		<% loop Products %>
		<tr class="product" data-price="$getPriceUnique" data-value="$ProductCode">
			<td><input type="number" min="0" max="10" class="uk-input uk-form-small" /></td>
			<td class="uk-table-expand">$Title<br><small>$Subtitle</small></td>
			<td class="uk-table-shrink">$PrintPriceString</td>
			<td class="sub-total uk-text-right"></td>
		</tr>
		<% end_loop %>
		</tbody>
		<tfoot>
			<tr><td colspan="2">&nbsp;</td><td class="uk-table-shrink">Gesamtpreise</td><td id="total-price" class="uk-text-right"></td></tr>
		</tfoot>
		<tbody>
	</table>
	<div class="uk-margin">
		<div class="uk-text-right">
			<a href="" class="uk-button">Jetzt bestellen</a>
		</div>
	</div>
	<% else %>
	<p><i>Zurzeit keine Produkte verfügbar</i></p>
	<% end_if %>
</div>