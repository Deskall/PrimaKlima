<div class="uk-position-fixed uk-position-center-right uk-position-small">
	<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
		<div class="uk-card-header">
			<h3 class="uk-card-title"><%t Webshop.Cart 'Einkaufswagen' %></h3>
		</div>
		<div class="uk-card-body order-preview">
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
		</div>
		<div class="uk-card-footer">
			<a href="$Top.ShopPage.Link" class="uk-button BlackBackground"><%t Webshop.Checkout 'Zur Kasse' %></a>
		</div>
	</div>
</div>
