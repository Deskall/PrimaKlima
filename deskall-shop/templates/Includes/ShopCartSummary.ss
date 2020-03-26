<table class="uk-table uk-table-small uk-table-justify uk-table-divider">
	<thead><th colspan="2"><%t Webshop.Article 'Artikel' %></th><th><%t Webshop.Quantity 'Menge' %></th><th><%t Webshop.Total 'Gesamtsumme' %></th></thead>
	<tbody>
		<% if Products.exists %>
		<% loop Products.Sort('Sort') %>
		<tr>
			<td><img src="$MainBild.FocusFill(80,80).URL" class="uk-border-circle" /></td>
			<td class="uk-text-truncate uk-table-expand">$Title<br/><%t Webshop.Price 'Stückpreis' %>: $Price.Nice</td><td>$Quantity</td><td>$Up.SubTotalPrice($ID)</td>
		</tr>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total</td><td id="total-price" class="uk-text-right uk-text-bold">$TotalPrice.Nice</td></tr>
	</tfoot>
</table>
<div class="uk-margin-small">$countProducts <%t Webshop.CartProducts 'Artikel' %></div>