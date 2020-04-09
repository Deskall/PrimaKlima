<table cellspacing="2">
	<tr>
		<td>
			<address>
			$Participant.printAddress
			</address>
		</td>
		<td align="right">
			<address><% if $SiteConfig.AddressTitle %> $SiteConfig.AddressTitle<br/><% end_if %><% if $SiteConfig.Address %>$SiteConfig.Address<br/><% end_if %><% if $SiteConfig.Code %> $SiteConfig.Code - $SiteConfig.City<br/><% end_if %><% if $SiteConfig.Country %>$SiteConfig.Country<% end_if %></address>
		</td>
	</tr>
</table>
<h2>Rechnung</h2>
<table cellspacing="2">
	<tr style="font-size:12px;"><td>Rechnung Nr. $Nummer</td><td>Kunde Nr. $Participant.ID</td><td align="right">Datum: $Created.format('dd.MM.Y')</td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="410"><%t Event.Label 'Kurs' %></th><th width="120" align="right"><%t Event.SubTotal 'Gesamt' %></th></tr>
	</thead>
	<tbody>
		<tr><td width="410">$Date.Event.Title</td><td width="120" align="right">$Price.Nice</td></tr>
		<% if Voucher.exists %>
		<tr><td width="410"><%t Order.Voucher 'Gutschein' %></td><td align="right"><%t Order.VoucherLabel 'Rabatt' %> - $Voucher.NiceAmount</td></tr>
		<% end_if %>

		<tr style="font-size:12px;"><td width="410" style="border-top:1px solid #ccc;"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td style="border-top:1px solid #ccc;" align="right">$MwSt.Nice</td></tr>
		<tr style="font-size:14px;font-weight:bold;"><td width="410"><b><%t Event.TotalPrice 'Preis inklusive MwSt.' %></b></td><td align="right"><b>$TotalPrice.Nice</b></td></tr>
	</tbody>
</table>
<% if isPaid %>
<p style="font-size:16px;"><%t Order.paid 'Bezahlt' %></p>
<% else %>
	<% if PaymentType == "bill" %>
	<p style="font-size:12px;"><%t Bill.PayNow 'Der Gesamtbetrag ist ab sofort auf unser unten genanntes Konto zu zahlen.' %></p>
	$SiteConfig.BankAccount
	<% end_if %>
<% end_if %>