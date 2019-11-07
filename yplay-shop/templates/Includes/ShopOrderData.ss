<h3>Monatliche Kosten</h3>
<table>
	<tbody>
		<% if Package.exists %>
		<% with Package %>
		<tr><td>$Title</td><td>$PrintPriceString</td></tr>
		<tr><td colspan="2"><% loop Products %>$Title<br><% end_loop %></td></tr>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
		<tr><td>$Title</td><td>$PrintPriceString</td></tr>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (monatlich)</td><td>$TotalMonthlyPrice</td></tr>
	</tfoot>
</table>
<h3>Einmalige Kosten</h3>
<table>
	<tbody>
		<% if Package %>
		<% with Package %>
		<% if UniquePrice > 0 %>
		<tr><td>$UniquePriceLabel</td><td>CHF $UniquePrice</td></tr>
		<% end_if %>
		<% if ActivationPrice > 0 %>
		<tr><td>$ActivationPriceLabel</td><td>CHF $ActivationPrice</td></tr>
		<% end_if %>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
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
		<tr><td>Total (einmalig)</td><td>$TotalUniquePrice</td></tr>
	</tfoot>
</table>