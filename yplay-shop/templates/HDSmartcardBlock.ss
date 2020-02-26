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
			<td><input type="number" min="0" max="10" class="uk-input uk-form-small uk-width-small" /></td>
			<td>$Title<br><small class="uk-visible@m">$Subtitle</small></td>
			<td class="uk-table-shrink">$PrintPriceString</td>
			<td class="sub-total uk-text-right uk-text-nowrap"></td>
		</tr>
		<% end_loop %>
		</tbody>
		<tfoot>
			<tr><td colspan="2">&nbsp;</td><td class="uk-table-shrink uk-text-bold">Gesamtpreise</td><td id="total-price" class="uk-text-right uk-text-nowrap uk-text-bold"></td></tr>
		</tfoot>
		<tbody>
	</table>
	<div class="uk-margin">
		<div class="uk-text-right">
			<a class="uk-button" data-submit-smartcard>Jetzt bestellen</a>
		</div>
	</div>
	<% else %>
	<p><i>Zurzeit keine Produkte verfügbar</i></p>
	<% end_if %>
</div>