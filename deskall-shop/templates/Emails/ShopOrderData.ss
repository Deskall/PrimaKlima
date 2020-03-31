<h2><%t Webshop.OrderDetail 'Details' %></h2>


<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="310" colspan="2"><%t Webshop.Product 'Produkt' %></th><th width="100" align="center"><%t Webshop.Quantity 'Menge' %></th><th width="120" align="right" style="text-align:right"><%t Webshop.Total 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<% loop Items %>
		<tr style="font-size:12px;"><td width="80"><img src="$Product.MainBild.FocusFill(80,80).absoluteURL" style="margin-right:10px;" width="80" height="80"/></td><td width="230">$Product.Title</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$Price</td></tr>
		<% end_loop %>
		<% if Voucher.exists %>
		<tr><td colspan="3"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>

		<tr style="font-size:12px;"><td colspan="3" style="border-top:1px solid #ccc;"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td style="border-top:1px solid #ccc;" align="right">$MwSt</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b><%t Webshop.Total 'Gesamtsumme:' %></b></td><td align="right"><b>$TotalPrice</b></td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b><%t Webshop.Transport 'Porto und Verpackung' %></b></td><td align="right"><b>$TransportPrice</b></td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td colspan="3"><b><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></b></td><td align="right"><b>$FullTotalPrice</b></td></tr>
	</tbody>
</table>