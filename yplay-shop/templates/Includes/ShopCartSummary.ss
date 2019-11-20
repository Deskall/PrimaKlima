
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
				<tr><td>$Title</td><td style="text-align:right">$PrintPriceString</td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if RecurringPrice %>
			<tr><td>$Title</td><td align="right">$PrintPriceString</td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if Package %>
		<% with Package %>
		<% if UniquePrice > 0 %>
		<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $UniquePrice</td></tr>
		<% end_if %>
		<% if ActivationPrice > 0 %>
		<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $ActivationPrice</td></tr>
		<% end_if %>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td style="text-align:right">$PrintPriceString</td></tr>
			<% else %>
				<% if UniquePrice > 0 %>
				<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $UniquePrice</td></tr>
				<% end_if %>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $ActivationPrice</td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td style="text-align:right">$PrintPriceString</td></tr>
			<% else %>
				<% if UniquePrice > 0 %>
				<tr><td>$UniquePriceLabel</td><td style="text-align:right">CHF $UniquePrice</td></tr>
				<% end_if %>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td>$ActivationPriceLabel</td><td style="text-align:right">CHF $ActivationPrice</td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<tr><td>Total (einmalig)</td><td id="total-unique-price" class="uk-text-right uk-text-bold">$TotalUniquePrice</td></tr>
	</tbody>
</table>