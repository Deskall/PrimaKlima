<address>
$Customer.printAddress
</address>
<h2><%t Bill.Title 'Rechnung' %></h2>
<table cellspacing="2">
	<tr style="font-size:12px;"><td><%t Bill.BillNumber 'Rechnung Nr.' %> $Nummer</td><td><%t Bill.CustomerNumber 'Kunde Nr.' %> $CustomerID</td><td align="right"><%t Bill.Date 'Datum:' %>' $Created.format('dd.MM.Y')</td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="210"><%t Bill.Product 'Leistung' %></th><th width="100" align="center"><%t Bill.ProductPrice 'Einzelpreis' %></th><th width="100" align="center"><%t Bill.Quantity 'Menge' %></th><th width="120" align="right"><%t Bill.Subtotal 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<tr><td width="210">$Product.Title</td><td width="100" align="center">$Product.CurrentPrice</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$OrderSubPrice</td></tr>
		<% if not Product.Online %><tr><td colspan="3"><%t Product.TransportCost 'Transportkosten (pauschal Preis)' %><% if Product.DeliveryTime %><br/><%t Product.DeliveryTime 'Lieferzeit:' %> $Product.DeliveryTime<% end_if %></td><td align="right">$ProductConfig.TransportCost EUR</td></tr><% end_if %>
		<tr><td colspan="3"><%t Bill.NettPrice 'Nettobetrag' %></td><td align="right">$OrderPriceNetto</td></tr>
		<tr><td colspan="3"><%t Bill.Tax 'MwSt. inkl' %></td><td align="right">$OrderMwst</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b><%t Bill.Total 'Gesamtbetrag' %></b></td><td align="right"><b>$OrderPrice</b></td></tr>
	</tbody>
</table>
<p style="font-size:12px;"><%t Bill.PayNow 'Der Gesamtbetrag ist ab sofort auf unser unten genanntes Konto zu zahlen.' %></p>