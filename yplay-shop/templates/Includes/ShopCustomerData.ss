
<h5 style="border-bottom:1px solid #EEEEEE;padding-bottom:10px;">Ihre Angaben</h5>
<table class="table-products" style="width:100%;margin-bottom:20px;">
	<tbody>
		<tr><td>Anrede</td><td style="text-align:right">$Gender</td></tr>
		<tr><td>Name</td><td style="text-align:right">$Name</td></tr>
		<tr><td>Vorname</td><td style="text-align:right">$Vorname</td></tr>
		<tr><td>E-Mail</td><td style="text-align:right">$Email</td></tr>
		<tr><td>Adresse</td><td style="text-align:right">$Address $HouseNumber</td></tr>
		<tr><td>Ort</td><td style="text-align:right">$PostalCode - $City</td></tr>
		<tr><td>Land</td><td style="text-align:right">$Country</td></tr>
		<tr><td>Tel.</td><td style="text-align:right">$Phone</td></tr>
		<% if Glasfaserdose %>
		<tr><td>Glasfaserdose-Nr.</td><td style="text-align:right">$Glasfaserdose</td></tr>
		<% end_if %>
		<% if UnknownGlasfaserdose %>
		<tr><td>Glasfaserdose-Nr.</td><td style="text-align:right">Unbekannt</td></tr>
		<% end_if %>
		<tr><td>Bisheriger Anbieter</td><td style="text-align:right">$PreviousProvider</td></tr>
		<tr><td>Wie sind Sie auf YplaY aufmerksam geworden?</td><td style="text-align:right">$Origin</td></tr>
		<tr><td>Zahlungsart</td><td style="text-align:right">$PaymentTyp</td></tr>
	</tbody>
</table>

<% if $Comments %>
<p style="background-color:#EEEEEE;padding:10px;">$Comments</p>
<% end_if %>