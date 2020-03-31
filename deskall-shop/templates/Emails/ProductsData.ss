<table cellspacing="4">
	<% loop Products %>
	<tr><td>&nbsp;</td><td></td></tr>
	<tr><td>Produkt:</td><td><div>$MainImage.FitMax(250,200)</div><div><strong>$Title</strong></div><div><small>$Subtitle</small></div><div>$LeadText</div></td></tr>
	<tr><td>Preis (inkl. MwSt.):</td><td><strong>$currentPrice €</strong></td></tr>
	<% end_loop %>
</table>