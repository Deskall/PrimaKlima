<strong class="uk-text-small"><%t Webshop.Cart 'Einkaufswagen' %></strong>
<table class="uk-table uk-table-small uk-table-justify">
	<tbody>
		<% if Products.exists %>
		<% loop Products.Sort('SortOrder') %>
			<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total</td><td id="total-price" class="uk-text-right uk-text-bold">$TotalPrice</td></tr>
	</tfoot>
</table>
