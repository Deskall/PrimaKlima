<h2><%t Webshop.OrderDetail 'Details' %></h2>
<table cellspacing="4" cellpadding="4" style="font-size:14px;">
	<tr><td><b><%t Webshop.OrderNumber 'Bestellung Nr.' %></b></td><td><b>$Nummer</b></td></tr>
	<tr><td><%t Webshop.OrderNumber 'Datum' %></td><td>$Created.format('dd.MM.Y H:I')</td></tr>
	<tr><td><%t Webshop.PaymentType 'Zahlungsart' %></td><td>$PaymentResource</td></tr>
	<tr>
		<td><b><%t Webshop.CustomerData 'Kunden Angaben' %></b><br/>$printAddress</td>
		<% if PaymentType == "bill" || PaymentType == "creditcart" %>
		<td><b><%t Webshop.DeliveryAddress 'Lieferadresse' %></b><br/>$printDeliveryAddress</td>
		<% end_if %>
	</tr>
</table>

<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="310" colspan="2" align="left"><%t Webshop.Product 'Produkt' %></th><th width="100" align="center"><%t Webshop.Quantity 'Menge' %></th><th width="120" align="right" style="text-align:right;padding-right:5px"><%t Webshop.Total 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<% loop Items %>
		<tr style="font-size:12px;"><td width="80" style="padding-top:5px;padding-bottom:5px;"><img src="$Product.MainBild.FocusFill(80,80).absoluteURL" style="margin-right:10px;" width="80" height="80"/></td><td width="230">$Product.Title<br/>$PriceUnique.Nice</td><td width="100" align="center">$Quantity</td><td width="120" align="right">$Price.Nice</td></tr>
		<% end_loop %>
		<% if Voucher.exists %>
		<tr><td colspan="3"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>

		<tr style="font-size:12px;"><td colspan="3" style="border-top:1px solid #ccc;padding-top:10px;"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td style="border-top:1px solid #ccc;padding-top:10px;" align="right">$MwSt.Nice</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><%t Webshop.Total 'Gesamtsumme:' %></td><td align="right">$TotalPrice.Nice</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><%t Webshop.Transport 'Porto und Verpackung' %></td><td align="right">$TransportPrice.Nice</td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td colspan="3"><b><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></b></td><td align="right"><b>$FullTotalPrice.Nice</b></td></tr>
	</tbody>
</table>