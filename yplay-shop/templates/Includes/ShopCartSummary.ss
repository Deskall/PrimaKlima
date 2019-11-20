
<table>
	<tbody>
		<% if Package.exists %>
		<% with Package %>
		<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
		<tr><td colspan="2" class="products-package"><% loop Products %>$Title<br><% end_loop %></td></tr>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products.Sort('SortOrder') %>
			<% if RecurringPrice %>
				<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if RecurringPrice %>
			<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (monatlich)</td><td id="total-monthly-price" class="uk-text-right uk-text-bold">$TotalMonthlyPrice</td></tr>
	</tfoot>
</table>

<table>
	<tbody>
		<% if Package %>
		<% with Package %>
		<% if UniquePrice > 0 %>
		<tr><td>$UniquePriceLabel</td><td class="uk-text-right">CHF $UniquePrice</td></tr>
		<% end_if %>
		<% if ActivationPrice > 0 %>
		<tr><td>$ActivationPriceLabel</td><td class="uk-text-right">CHF $ActivationPrice</td></tr>
		<% end_if %>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
			<% else %>
				<% if UniquePrice > 0 %>
				<tr><td>$UniquePriceLabel</td><td class="uk-text-right">CHF $UniquePrice</td></tr>
				<% end_if %>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td>$ActivationPriceLabel</td><td class="uk-text-right">CHF $ActivationPrice</td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
			<% else %>
				<% if UniquePrice > 0 %>
				<tr><td>$UniquePriceLabel</td><td class="uk-text-right">CHF $UniquePrice</td></tr>
				<% end_if %>
			<% end_if %>
			<% if ActivationPrice > 0 %>
			<tr><td>$ActivationPriceLabel</td><td class="uk-text-right">CHF $ActivationPrice</td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (einmalig)</td><td id="total-unique-price" class="uk-text-right uk-text-bold">$TotalUniquePrice</td></tr>
	</tfoot>
</table>