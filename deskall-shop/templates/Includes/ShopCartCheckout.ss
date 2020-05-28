<% if Products.exists %>
<table class="uk-table uk-table-small uk-table-divider uk-table-middle product-table">
	<thead><th><%t Webshop.Product 'Produkt' %></th><th class="uk-text-center uk-table-shrink"><%t Webshop.Quantity 'Menge' %></th><th class="uk-text-right"><%t Webshop.UniquePrice 'Einzelpreis' %></th><th>&nbsp;</th></thead>
	<tbody>
		<% loop Products %>
		<tr><td>$Title</td><td class="uk-text-center"><input type="number" value="$Quantity" min="1" class="uk-input" data-quantity data-product="<% if VariantID > 0 %>$Variant.ProductID<% else %>$ProductID<% end_if %>" data-variant="$VariantID"></td><td class="uk-text-right">$Price.Nice</td><td class="uk-text-center"><a data-remove-product="$ID"><i data-uk-icon="trash"></i></a></td></tr>
		<% end_loop %>
	</tbody>
	<tfoot><tr><td class="uk-text-bold" colspan="2"><%t Webshop.TotalPrice 'Total' %></td><td class="uk-text-bold uk-text-right">$TotalPrice.Nice</td><td>&nbsp;</td></tr></tfoot>
</table>
<% else %>
<p><i>Ihr Warenkorb enthält keine Produkte</i></p>
<div class="uk-margin">
	<a href="$Webshop.Link" class="uk-button button-WebshopBackground">Zum Webshop<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
</div>
<% end_if %>