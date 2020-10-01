<% if $MonthlyPrice > 0 %>
<h5 style="border-bottom:1px solid #EEEEEE;padding-bottom:10px;">Monatliche Kosten</h5>
<table class="table-products" style="width:100%;margin-bottom:20px;">
	<tbody>
		<% if Items.exists %>
			<% loop Items %>
			<% if MonthlyPrice > 0 %>
				<tr><td>$Title</td><td style="text-align:right">CHF $MonthlyPrice / Mt. <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% if Type == "package" %>
				<tr><td colspan="2"><% loop $Package.Products %>$Title<br><% end_loop %></td></tr>
				<% end_if %>
			<% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if PaymentTyp == "Paper" %>
		<tr><td>$SiteConfig.PaperBillLabel</td><td style="text-align:right">$SiteConfig.PaperBillPrice.Nice / Mt.</td></tr>
		<% end_if %>
		<tr style="background-color:#EEEEEE;"><td style="font-weight:bold;">Total (monatlich)</td><td style="font-weight:bold;text-align:right">CHF $MonthlyPrice / Mt.</td></tr>
	</tbody>
</table>
<% end_if %>
<% if UniquePrice > 0 %>
<h5 style="border-bottom:1px solid #EEEEEE;padding-bottom:10px;">Einmalige Kosten</h5>
<table class="table-products" style="width:100%;margin-bottom:20px;">
	<tbody>
		
		<% if Items.exists %>
			<% loop Items %>
			<% if UniquePrice > 0 %>
			<tr><td><% if $UniquePriceLabel %>$UniquePriceLabel<% else %>$Title<% end_if %></td><td style="text-align:right">CHF $UniquePrice <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td><% if $ActivationPriceLabel %>$ActivationPriceLabel<% else %>$Title<% end_if %></td><td style="text-align:right">CHF $ActivationPrice <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if $ExistingCustomer == 2 %>
		<tr><td>$SiteConfig.ActivationPriceLabel</td><td style="text-align:right">$SiteConfig.ActivationPrice.Nice</td></tr>
		<% end_if %>
		<tr style="background-color:#EEEEEE;"><td style="font-weight:bold;">Total (einmalig)</td><td style="font-weight:bold;text-align:right">CHF $UniquePrice</td></tr>
	</tbody>
</table>
<% end_if %>