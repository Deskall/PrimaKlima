<h5>Monatliche Kosten</h5>
<table>
	<tbody>
		<% if Items.exists %>
			<% loop Items %>
			<tr><td>$Title</td><td style="text-align:right">$MonthlyPrice</td></tr>
				<% if Type == "package" %>
				<tr><td colspan="2"><% loop Products %>$Title<br><% end_loop %></td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (monatlich)</td><td style="text-align:right">$MonthlyPrice</td></tr>
	</tfoot>
</table>
<h5>Einmalige Kosten</h5>
<table>
	<tbody>
		
		<% if Items.exists %>
			<% loop Items %>
			<% if UniquePrice > 0 %>
			<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $UniquePrice</td></tr>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $ActivationPrice</td></tr>
			<% end_if %>
			<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (einmalig)</td><td style="text-align:right">$UniquePrice</td></tr>
	</tfoot>
</table>