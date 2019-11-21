<table class="uk-table uk-table-small">
	<tr><td><%t Customer.Title 'Kunde' %></td><td>$Customer.Member.Title</td></tr>
	<tr><td><%t Customer.Email 'E-Mail-Adresse' %></td><td><a href="mailto:$Customer.Member.Email">$Customer.Member.Email</a></td></tr>
	<tr><td><%t Customer.Phone 'Telefonnumer' %></td><td><a href="tel:$Customer.Phone">$Customer.Phone</a></td></tr>
</table>