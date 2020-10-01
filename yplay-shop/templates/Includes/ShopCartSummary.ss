
<table>
	<tbody>
		<% if Package.exists %>
		<% with Package %>
		<tr><td>$Title</td><td style="text-align:right">$PrintPriceString</td></tr>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products.Sort('SortOrder') %>
			<% if RecurringPrice %>
				<tr><td>$Title</td><td style="text-align:right">$PrintPriceString<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if RecurringPrice %>
			<tr><td>$Title</td><td align="right">$PrintPriceString<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if PaymentTyp == "Paper" %>
		<tr><td>$SiteConfig.PaperBillLabel</td><td style="text-align:right">$SiteConfig.PaperBillPrice.Nice / Mt.</td></tr>
		<% end_if %>
		<% if $TotalMonthlyPrice > 0 %>
		<tr><td>Total (monatlich)</td><td style="text-align:right;font-weight:bold">$PrintMonthlyPrice</td></tr>
		<% end_if %>
		<% if Package %>
		<% with Package %>
		<% if $getPriceUnique > 0 %>
		<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $getPriceUnique</td></tr>
		<% end_if %>
		<% if getFees > 0 %>
		<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $getFees</td></tr>
		<% end_if %>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td style="text-align:right">$PrintPriceString<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% else %>
				<% if $getPriceUnique > 0 %>
				<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $getPriceUnique<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% end_if %>
			<% end_if %>
			<% if getFees > 0 %>
			<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $getFees<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td style="text-align:right">$PrintPriceString<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% else %>
				<% if $getPriceUnique > 0 %>
				<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $getPriceUnique<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% end_if %>
			<% end_if %>
			<% if getFees > 0 %>
			<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $getFees<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if $TotalUniquePrice > 0 %>
		<tr><td>Total (einmalig)</td><td style="text-align:right;font-weight:bold">$PrintUniquePrice</td></tr>
		<% end_if %>
	</tbody>
</table>