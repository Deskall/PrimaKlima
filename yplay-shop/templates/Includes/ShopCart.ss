<strong class="uk-text-small">Monatliche Kosten</strong>
<% if Package.exists && $Package.PriceGain.gainM < 0 %><p>Sie sparen {$Package.PriceGain.gainM}%</p><% end_if %>
<table id="monthly-costs" class="uk-table uk-table-small uk-table-justify">
	<tbody>
		<% if Package.exists %>
		<% with Package %>
		<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
		<tr><td colspan="2" class="products-package"><% loop Products %>$Title<br><% end_loop %></td></tr>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
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
<strong class="uk-text-small">Einmalige Kosten</strong>
<% if Package.exists && $Package.PriceGain.gainU < 0 %><p>Sie sparen {$Package.PriceGain.gainU}%</p><% end_if %>
<table id="unique-costs" class="uk-table uk-table-small uk-table-justify">
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
			<% if RecurringPrice %>
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
			<% if RecurringPrice %>
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
<div class="uk-margin-small">
	<a data-uk-toggle="#modal-conditions" data-uk-icon="chevron-right">Konditionen</a>
</div>
<div class="uk-margin-small">
	<div class="uk-flex uk-flex-middle">
		<img src="$ThemeDir/img/gift-solid.svg" class="uk-margin-small-right" width="50">
		<div>
			<strong>Aktion</strong><br>
			<small>3 Monate 1/2 Preis</small>
		</div>
	</div>
</div>