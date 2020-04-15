<h2><%t Event.OrderDetail 'Details' %></h2>
<table cellspacing="4" cellpadding="4" style="font-size:14px;">
	<tr><td><b><%t Event.OrderNumber 'Bestellung Nr.' %></b></td><td><b>$Nummer</b></td></tr>
	<tr><td><%t Event.OrderNumber 'Datum' %></td><td>$Created.format('dd.MM.Y')</td></tr>
	<tr><td><%t Event.PaymentType 'Zahlungsart' %></td><td>$PaymentResource</td></tr>
	<tr>
		<td><b><%t Event.CustomerData 'Kunden Angaben' %></b><br/>$printAddress</td>
	</tr>
</table>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="410" align="left" style="padding-left:5px;"><%t Event.Kurs 'Kurs' %></th><th width="120" align="right" style="text-align:right;padding-right:5px"><%t Event.Total 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<tr><td width="410" style="padding-left:5px;">$Date.Event.Title</td><td width="120" align="right">$Price.Nice</td></tr>
		<% if Voucher.exists %>
		<tr><td width="410" style="padding-left:5px;"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>

		<tr style="font-size:12px;"><td width="410" style="border-top:1px solid #ccc;padding-left:5px;"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td style="border-top:1px solid #ccc;" align="right">$MwSt.Nice</td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td width="410" style="padding-left:5px;"><b><%t Event.TotalPrice 'Preis inklusive MwSt.' %></b></td><td align="right"><b>$TotalPrice.Nice</b></td></tr>
	</tbody>
</table>