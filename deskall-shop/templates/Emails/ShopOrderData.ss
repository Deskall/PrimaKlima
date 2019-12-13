<h4>Bestellung</h4>
<table cellspacing="2">
	<tr style="font-size:12px;"><td>Bestellung Nr. $Nummer</td><td>Kunde Nr. $CustomerID</td><td align="right">Datum: $Created.format('dd.MM.Y')</td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="210">Leistung</th><th width="100" align="center">Einzelpreis</th><th width="100" align="center">Menge</th><th width="120" align="right">Gesamt</th></tr>
	</thead>
	<tbody>
		<tr style="font-size:12px;"><td width="210">$Product.Title</td><td width="100" align="center">$Product.CurrentPrice</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$OrderSubPrice</td></tr>
		<% if not Product.Online %><tr style="font-size:12px;"><td colspan="3"><%t Product.TransportCost 'Transportkosten (pauschal Preis)' %></td><td align="right">$ProductConfig.TransportCost EUR</td></tr><% end_if %>
		<tr style="font-size:12px;"><td colspan="3">Nettobetrag</td><td align="right">$OrderPriceNetto</td></tr>
		<tr style="font-size:12px;"><td colspan="3">MwSt. inkl</td><td align="right">$OrderMwst</td></tr>
		<tr style="font-size:16px;"><td colspan="3"><b>Gesamtbetrag</b></td><td align="right"><b>$OrderPrice</b></td></tr>
	</tbody>
</table>
<br/><br/><br/>