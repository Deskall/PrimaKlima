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
		<tr><td colspan="3"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>
		<tr><td colspan="3">Nettobetrag</td><td align="right">$OrderPriceNetto</td></tr>
		<tr><td colspan="3">MwSt. inkl</td><td align="right">$OrderMwst</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b>Gesamtbetrag</b></td><td align="right"><b>$TotalPrice</b></td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b>Versandkosten</b></td><td align="right"><b>$TransportPrice</b></td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b>Total</b></td><td align="right"><b>$FullTotalPrice</b></td></tr>
	</tbody>
</table>