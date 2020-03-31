<h2><%t Webshop.Order 'Bestellung' %></h2>
<table cellspacing="4" cellpadding="4">
	<tr style="font-size:16px;"><td><%t Webshop.OrderNumber 'Bestellung Nr.' %> <b>$Nummer</b></td><td><%t Webshop.CustomerNumber 'Kunde Nr.' %> <b>$Customer.Nummer</b></td><td align="right"><%t Webshop.Date 'Datum:' %> <b>$Created.format('dd.MM.Y')</b></td></tr>
</table>

<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="80"></th><%t Webshop.Product 'Produkt' %><th width="230"></th><th width="100" align="center"><%t Webshop.Quantity 'Menge' %></th><th width="120" align="right" style="text-align:right"><%t Webshop.Total 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<% loop Items %>
		<tr style="font-size:12px;"><td width="80"><img src="$MainBild.FocusFill(80,80).URL" width="80" height="80" /><td width="230">$Product.Title</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$Price</td></tr>
		<% end_loop %>
		<% if Voucher.exists %>
		<tr><td colspan="2"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>

		<tr style="font-size:12px;"><td colspan="2" style="border-top:1px solid #666;"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td style="border-top:1px solid #666;" align="right">$MwSt</td></tr>
		<tr style="font-size:12px;"><td colspan="2"><b><%t Webshop.Total 'Gesamtsumme:' %></b></td><td align="right"><b>$TotalPrice</b></td></tr>
		<tr style="font-size:12px;"><td colspan="2"><b><%t Webshop.Transport 'Porto und Verpackung' %></b></td><td align="right"><b>$TransportPrice</b></td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td colspan="2"><b><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></b></td><td align="right"><b>$FullTotalPrice</b></td></tr>
	</tbody>
</table>