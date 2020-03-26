<table class="uk-table uk-table-small uk-table-justify uk-table-divider">
	<thead><th colspan="2"><%t Webshop.Article 'Artikel' %></th><th class="uk-text-center"><%t Webshop.Quantity 'Menge' %></th><th class="uk-text-right"><%t Webshop.Total 'Gesamtsumme' %></th></thead>
	<tbody>
		<% if Products.exists %>
		<% loop Products.Sort('Sort') %>
		<tr>
			<td><img src="$MainBild.FocusFill(80,80).URL" class="uk-border-circle" /></td>
			<td class="uk-text-truncate uk-table-expand">$Title<br/><%t Webshop.Price 'Stückpreis' %>: $Price.Nice</td><td class="uk-text-center">$Quantity</td><td class="uk-text-right">$Subtotal.Nice</td>
		</tr>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td colspan="3" class="uk-text-right"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $Config.MwSt %</td><td id="total-price" class="uk-text-right">$TotalPrice.Nice</td></tr>
		<tr><td colspan="3" class="uk-text-right"><strong><%t Webshop.Total 'Gesamtsumme:' %></strong></td><td id="total-price" class="uk-text-right uk-text-bold"><strong>$TotalPrice.Nice</strong></td></tr>
		<tr><td colspan="3" class="uk-text-right"><%t Webshop.Transport 'Porto und Verpackung' %></td><td class="uk-text-right">$Config.TransportPrice.Nice</td></tr>
		<tr><td colspan="3" class="uk-text-right"><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></td><td class="uk-text-right">$FullTotalPrice.Nice</td></tr>
	</tfoot>
</table>
<div class="uk-margin-small">$countProducts <%t Webshop.CartProducts 'Artikel' %></div>