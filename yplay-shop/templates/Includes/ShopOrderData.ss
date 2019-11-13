<h3>Monatliche Kosten</h3>
<table>
	<tbody>
		<% if Items.exists %>
			<% loop Items %>
			<tr><td>$Title</td><td>$MonthlyPrice</td></tr>
				<% if Type == "package" %>
				<tr><td colspan="2"><% loop Products %>$Title<br><% end_loop %></td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (monatlich)</td><td>$getNiceMonthlyPrice</td></tr>
	</tfoot>
</table>
<h3>Einmalige Kosten</h3>
<table>
	<tbody>
		
		<% if Items.exists %>
			<% loop Items %>
			<% if UniquePrice > 0 %>
			<tr><td>$UniquePriceLabel</td><td>CHF $UniquePrice</td></tr>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td>$ActivationPriceLabel</td><td>CHF $ActivationPrice</td></tr>
			<% end_if %>
			<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (einmalig)</td><td>$getNiceUniquePrice</td></tr>
	</tfoot>
</table>