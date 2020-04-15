<div class="uk-panel uk-background-muted uk-padding-small">
	<h4><%t Checkout.SummaryTitle 'Ihre Bestellung' %></h4>
	<table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-table-justify uk-table-responsive">
		<thead><th colspan="2"><%t Webshop.Article 'Artikel' %></th><th class="uk-text-center"><%t Webshop.Quantity 'Menge' %></th><th class="uk-text-right"><%t Webshop.Price 'Preis' %></th></thead>
		<tbody class="uk-table-divider">
			<% if Products.exists %>
			<% loop Products.Sort('Sort') %>
			<tr>
				<td><img src="$MainBild.FocusFill(80,80).URL" class="uk-border-circle" /></td>
				<td class="uk-text-truncate uk-table-expand">$Title<br/><%t Webshop.Price 'Stückpreis' %>: $Price.Nice</td><td class="uk-text-center@m">$Quantity</td><td class="uk-text-right">$Subtotal.Nice</td>
			</tr>
			<% end_loop %>
			<% end_if %>
		
		
			<% if Voucher.exists %><tr><td colspan="3" class="uk-text-right"><%t Webshop.Voucher 'Gutschein:' %></td><td id="voucher-price" class="uk-text-right">- $DiscountPrice.Nice</td></tr><% end_if %>
			<tr><td colspan="3" class="uk-text-right"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td id="total-price" class="uk-text-right">$MwSt.Nice</td></tr>
			<tr><td colspan="3" class="uk-text-right"><strong><%t Webshop.SubTotal 'Zwischentotal:' %></strong></td><td id="total-price" class="uk-text-right uk-text-bold"><strong>$TotalPrice.Nice</strong></td></tr>
			<tr><td colspan="3" class="uk-text-right"><%t Webshop.Transport 'Porto und Verpackung' %></td><td class="uk-text-right">$TransportPrice.Nice</td></tr>
			<tr class="uk-table-divider"><td colspan="3" class="uk-text-right"><strong><%t Webshop.TotalPrice 'Total inkl. MwSt., Porto und Verpackung' %></strong></td><td class="uk-text-right"><strong id="full-total-price" data-price="$FullTotalPrice.Value">$FullTotalPrice.Nice</strong></td></tr>
		</tbody>
	</table>
</div>
<div class="uk-margin">
	<div class="uk-panel uk-background-muted uk-padding-small">
		<h4><%t Webshop.PaymentType 'Zahlungsart' %></h4>
		$PaymentResource
	</div>
</div>
<div class="uk-margin">
	<div class="<% if  PaymentMethod == "bill" || PaymentMethod == "online" %>uk-child-width-1-2@s uk-grid-match<% end_if %> uk-grid-small" data-uk-grid>
		<div>
			<div class="uk-panel uk-background-muted uk-padding-small">
				<h4><% if PaymentMethod == "bill" || PaymentMethod == "online" %><%t Webshop.BillAddressTitle 'Rechnungsadresse' %><% else %><%t Webshop.CustomerData 'Ihre Angaben' %><% end_if %></h4>
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
		</div>
		<% if  PaymentMethod == "bill" || PaymentMethod == "online" %>
		<div>
			<div class="uk-panel uk-background-muted uk-padding-small">
				<h4><%t Webshop.DeliveryAddress 'Lieferadresse' %></h4>
				$printDeliveryAddress
				<h4><%t Webshop.DeliveryConditions 'Lieferbedingungen' %></h4>
				$SiteConfig.DeliveryLabel
			</div>
		</div>
		<% end_if %>
	</div>
</div>
