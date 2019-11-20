<h5 style="border-bottom:1px solid #EEEEEE;padding-bottom:10px;">Monatliche Kosten</h5>
<table class="table-products" style="width:100%;margin-bottom:20px;">
	<tbody>
		<% if Items.exists %>
			<% loop Items %>
			<tr><td>$Title</td><td style="text-align:right">CHF $MonthlyPrice / Mt.</td></tr>
				<% if Type == "package" %>
				<tr><td colspan="2"><% loop Products %>$Title<br><% end_loop %></td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
		<tr><td style="font-weight:bold;">Total (monatlich)</td><td style="font-weight:bold;text-align:right">CHF $MonthlyPrice / Mt.</td></tr>
	</tbody>
</table>
<h5 style="border-bottom:1px solid #EEEEEE;padding-bottom:10px;">Einmalige Kosten</h5>
<table class="table-products" style="width:100%;margin-bottom:20px;">
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
	
		<tr><td style="font-weight:bold;">Total (einmalig)</td><td style="font-weight:bold;text-align:right">CHF $UniquePrice</td></tr>
	</tbody>
</table>