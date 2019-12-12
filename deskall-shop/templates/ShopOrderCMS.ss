<h2>Kunde</h2>
$Customer.printAddress
<br/>
<h2>Produkt</h2>
$Product.Title
<br/><br/>
<h2>Bestellung</h2>
<table cellspacing="4" cellpadding="4">
	<tr style="font-size:16px;"><td>Bestellung Nr. <b>$Nummer</b></td><td>Kunde Nr. <b>$CustomerID</b></td><td align="right">Datum: <b>$Created.format('dd.MM.Y')</b></td><td>Typ: <b>$PaymentResource</b></td><td>Bezahlt: <b>$PaidStatus</b></td><td><% if isPaid %>$ReceiptFile<% else %>$BillFile<% end_if %></td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="210">Paket</th><th width="100" align="center">Laufzeit</th><th width="100" align="center">Anzahl Anzeige</th><th width="120" align="right">Gesamt</th></tr>
	</thead>
	<tbody>
		<tr><td width="210">$Product.Title</td><td width="100" align="center">$Product.RunTimeTitle</td><td width="100" align="center">$NumOfAdsTitle</td><td width="120" align="right">$OrderSubPrice</td></tr>
		<tr><td colspan="3">Nettobetrag</td><td align="right">$OrderPriceNetto</td></tr>
		<tr><td colspan="3">MwSt. inkl</td><td align="right">$OrderMwst</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b>Gesamtbetrag</b></td><td align="right"><b>$OrderPrice</b></td></tr>
	</tbody>
</table>