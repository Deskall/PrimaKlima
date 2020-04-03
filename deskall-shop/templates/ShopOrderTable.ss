<table cellspacing="2">
	<tr>
		<td>
			<address>
			$Customer.printAddress
			</address>
		</td>
		<td>
			<address><% if $SiteConfig.AddressTitle %> $SiteConfig.AddressTitle<br/><% end_if %><% if $SiteConfig.Address %>$SiteConfig.Address<br/><% end_if %><% if $SiteConfig.Code %> $SiteConfig.Code - $SiteConfig.City<br/><% end_if %><% if $SiteConfig.Country %>$SiteConfig.Country<% end_if %></address>
		</td>
	</tr>
</table>
<h2><%t Bill.Title 'Rechnung' %></h2>
<table cellspacing="2">
	<tr style="font-size:12px;"><td><%t Bill.BillNumber 'Rechnung Nr.' %> $Nummer</td><td align="right"><%t Bill.Date 'Datum:' %> $Created.format('dd.MM.Y')</td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="310"><%t Webshop.Product 'Produkt' %></th><th width="100" align="center"><%t Webshop.Quantity 'Menge' %></th><th width="120" align="right" style="text-align:right;padding-right:5px"><%t Webshop.Total 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<% loop Items %>
		<tr style="font-size:12px;padding-top:5px;padding-bottom:5px;"><td width="310">$Product.Title<br/>$PriceUnique.Nice</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$Price.Nice</td></tr>
		<% end_loop %>
		<% if Voucher.exists %>
		<tr><td colspan="3"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>

		<tr style="font-size:12px;padding-top:10px;"><td colspan="3" style="border-top:1px solid #ccc;"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td style="border-top:1px solid #ccc;" align="right">$MwSt.Nice</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b><%t Webshop.Total 'Gesamtsumme:' %></b></td><td align="right"><b>$TotalPrice.Nice</b></td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b><%t Webshop.Transport 'Porto und Verpackung' %></b></td><td align="right"><b>$TransportPrice.Nice</b></td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td colspan="3"><b><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></b></td><td align="right"><b>$FullTotalPrice.Nice</b></td></tr>
	</tbody>
</table>
<% if PaymentType == "bill" %>
<p style="font-size:12px;"><%t Bill.PayNow 'Der Gesamtbetrag ist ab sofort auf unser unten genanntes Konto zu zahlen.' %></p>
$SiteConfig.BankAccount
<% end_if %>