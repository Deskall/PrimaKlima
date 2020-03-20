<h2>Rechnung</h2>
<table cellspacing="2">
	<tr style="font-size:12px;"><td>Rechnung Nr. $Nummer</td><td>Kunde Nr. $Participant.ID</td><td align="right">Datum: $Created.format('dd.MM.Y')</td></tr>
</table>
<hr>
<table cellpadding="2" cellspacing="2">
	<thead>
		<tr style="background-color:#EEEEEE;color:#666666;"><th width="210">Leistung</th><th width="100" align="center">Einzelpreis</th><th width="100" align="center">Menge</th><th width="120" align="right">Gesamt</th></tr>
	</thead>
	<tbody>
		<tr><td width="210">$Date.Event.Title</td><td width="100" align="center">$OrderPrice</td><td width="100" align="center">1</td><td width="120" align="right">$OrderPrice</td></tr>
		<tr><td colspan="3">Nettobetrag</td><td align="right">$OrderPriceNetto</td></tr>
		<tr><td colspan="3">MwSt. inkl</td><td align="right">$OrderMwst</td></tr>
		<tr style="font-size:12px;"><td colspan="3"><b>Gesamtbetrag</b></td><td align="right"><b>$OrderPrice</b></td></tr>
	</tbody>
</table>
<p style="font-size:12px;">Der Gesamtbetrag ist ab sofort auf unser unten genanntes Konto zu zahlen.</p>