<table class="uk-table uk-table-small uk-table-justify uk-table-divider">
				<tbody>
					<% if Products.exists %>
					<% loop Products.Sort('Sort') %>
						<% if VariantID > 0 %>
							<tr><td class="uk-text-truncate uk-table-expand" colspan="2">$Title - $Variants.byId($VariantID).Title <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
						<% else %>
							<tr><td class="uk-text-truncate uk-table-expand" colspan="2">$Title <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
						<% end_if %>
					<% end_loop %>
					<% end_if %>
				</tbody>
				<tfoot>
					<tr><td>Total</td><td id="total-price" class="uk-text-right uk-text-bold">$TotalPrice.Nice</td></tr>
				</tfoot>
			</table>
			<div class="uk-margin-small">$countProducts <%t Webshop.CartProducts 'Artikel' %></div>