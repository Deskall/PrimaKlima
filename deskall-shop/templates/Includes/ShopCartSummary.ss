<table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-table-justify">
	<thead><th colspan="2"><%t Webshop.Article 'Artikel' %></th><th class="uk-text-center"><%t Webshop.Quantity 'Menge' %></th><th class="uk-text-right"><%t Webshop.Total 'Gesamtsumme' %></th></thead>
	<tbody class="uk-table-divider">
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
		<% if Voucher.exists %><tr><td colspan="3" class="uk-text-right"><%t Webshop.Voucher 'Gutschein:' %></td><td id="voucher-price" class="uk-text-right">- $DiscountPrice.Nice</td></tr><% end_if %>
		<tr><td colspan="3" class="uk-text-right"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td id="total-price" class="uk-text-right">$MwSt.Nice</td></tr>
		<tr><td colspan="3" class="uk-text-right"><strong><%t Webshop.Total 'Gesamtsumme:' %></strong></td><td id="total-price" class="uk-text-right uk-text-bold"><strong>$TotalPrice.Nice</strong></td></tr>
		<tr><td colspan="3" class="uk-text-right"><%t Webshop.Transport 'Porto und Verpackung' %></td><td class="uk-text-right">$TransportPrice.Nice</td></tr>
		<tr class="uk-table-divider"><td colspan="3" class="uk-text-right"><strong><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></strong></td><td class="uk-text-right"><strong id="full-total-price" data-price="$FullTotalPrice.Value">$FullTotalPrice.Nice</strong></td></tr>
	</tfoot>
</table>
<div class="uk-margin">
	<div class="uk-child-width-1-2@s" data-uk-grid>
		<div>
			<h4><%t Webshop.BillAddressTitle 'Rechnungsadresse' %></h4>
			<p><% if Company %>$Company<br/><% end_if %>
				$Gender $FirstName $Name<br/>
				$Email<br/>
				$Phone<br/>
				<% if Street %>$Street<br/><% end_if %>
				<% if Address %>$Address<br/><% end_if %>
				<% if Region %>$Region<br/><% end_if %>
				<% if PostalCode %>$PostalCode -<% end_if %>
				<% if City %>$City<br/><% end_if %>
				<% if Country %>$NiceCountry<br/><% end_if %>
				<% if Address %>$Address<br/><% end_if %>
			</p>
			<% if $Additional %>
			<p>$Additional</p>
			<% end_if %>
		</div>
		<div>
			<h4>Lieferbedingungen</h4>
			$SiteConfig.DeliveryLabel
		</div>
	</div>
</div>