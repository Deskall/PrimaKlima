<h2>Kunde</h2>
$Customer.printAddress
<br/>
<h2>Bestellung</h2>
<table cellspacing="4" cellpadding="4">
	<tr style="font-size:16px;"><td>Bestellung Nr. <b>$Nummer</b></td><td>Kunde Nr. <b>$CustomerID</b></td><td align="right">Datum: <b>$Created.format('dd.MM.Y')</b></td><td>Typ: <b>$PaymentResource</b></td><td>Bezahlt: <b>$PaidStatus</b></td><td><% if isPaid %>$Receipt<% else %>$Bill<% end_if %></td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="310">Produkt</th><th width="100" align="center">Menge</th><th width="120" align="right">Gesamt</th></tr>
	</thead>
	<tbody>
		<% loop Items %>
		<tr><td width="310">$Product.Title</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$Price</td></tr>
		<% end_loop %>
		<% if Voucher.exists %>
		<tr><td colspan="2"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>
		<tr><td colspan="2"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td align="right">$MwSt</td></tr>
		<tr><td colspan="2">MwSt. inkl</td><td align="right">$OrderMwst</td></tr>
		<tr style="font-size:12px;"><td colspan="2"><b><%t Webshop.Total 'Gesamtsumme:' %></b></td><td align="right"><b>$TotalPrice</b></td></tr>
		<tr style="font-size:12px;"><td colspan="2"><b><%t Webshop.Transport 'Porto und Verpackung' %></b></td><td align="right"><b>$TransportPrice</b></td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td colspan="2"><b><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></b></td><td align="right"><b>$FullTotalPrice</b></td></tr>
	</tbody>
</table>