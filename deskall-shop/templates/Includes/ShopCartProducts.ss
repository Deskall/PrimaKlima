<table class="uk-table uk-table-small uk-table-justify uk-table-striped">
				<tbody>
					<% if Products.exists %>
					<% loop Products.Sort('Sort') %>
						<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
					<% end_loop %>
					<% end_if %>
				</tbody>
				<tfoot>
					<tr><td>Total</td><td id="total-price" class="uk-text-right uk-text-bold">$TotalPrice.Nice</td></tr>
				</tfoot>
			</table>