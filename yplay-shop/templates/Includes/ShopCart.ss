<% if $TotalMonthlyPrice > 0 %>
<strong class="uk-text-small">Monatliche Kosten</strong>
<% if Package.exists && $Package.PriceGain.gainM < 0 %><p>Sie sparen mit diesem Kombiabo {$Package.PriceGain.gainM}%</p><% end_if %>
<table id="monthly-costs" class="uk-table uk-table-small uk-table-justify">
	<tbody>
		<% if Package.exists %>
		<% with Package %>
		<tr><td>$Title</td><td class="uk-text-right"><% if $ActionMonthlyPrice %><s>$getMonthlyPrice</s> $PrintPriceString<% else %>$PrintPriceString<% end_if %></td></tr>
		<tr><td colspan="2" class="products-package"><% loop Products %>$Title<br><% end_loop %></td></tr>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products.Sort('SortOrder') %>
			<% if RecurringPrice %>
				<tr><td>$Title</td><td class="uk-text-right"><% if $ActionMonthlyPrice %><s>$getMonthlyPrice</s> $PrintPriceString<% else %>$PrintPriceString<% end_if %><% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% end_if %>
			<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if RecurringPrice %>
			<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (monatlich)</td><td id="total-monthly-price" class="uk-text-right uk-text-bold">$PrintMonthlyPrice</td></tr>
	</tfoot>
</table>
<% end_if %>
<% if not $ExistingCustomer || $ExistingCustomer < 1 %>
<div class="uk-margin-small">
	$ActivationPriceLabel
</div>
<% end_if %>
<% if $TotalUniquePrice > 0 %>
<strong class="uk-text-small">Einmalige Kosten</strong>
<% if Package.exists && $Package.PriceGain.gainU < 0 %><p>Sie sparen {$Package.PriceGain.gainU}%</p><% end_if %>
<table id="unique-costs" class="uk-table uk-table-small uk-table-justify">
	<tbody>
		<% if Package %>
		<% with Package %>
		<% if $getPriceUnique > 0 %>
		<tr><td>$UniquePriceLabel</td><td class="uk-text-right">CHF $getPriceUnique</td></tr>
		<% end_if %>
		<% if $getFees > 0 %>
		<tr><td>$ActivationPriceLabel</td><td class="uk-text-right">CHF $getFees</td></tr>
		<% end_if %>
		<% end_with %>
		<% end_if %>
		<% if Products.exists %>
		<% loop Products %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% else %>
				<% if $getPriceUnique > 0 %>
				<tr><td>$UniquePriceLabel</td><td class="uk-text-right">CHF $getPriceUnique <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% end_if %>
			<% end_if %>
			<% if $getFees > 0 %>
			<tr><td>$ActivationPriceLabel</td><td class="uk-text-right">CHF $getFees <% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if Options.exists %>
		<% loop Options %>
			<% if not RecurringPrice %>
				<tr><td>$Title</td><td class="uk-text-right">$PrintPriceString <% if Quantity > 1 %>* $Quantity<% end_if %></td></tr>
			<% else %>
				<% if $getPriceUnique > 0 %>
				<tr><td>$UniquePriceLabel</td><td class="uk-text-right">CHF $getPriceUnique<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
				<% end_if %>
			<% end_if %>
			<% if $getFees > 0 %>
			<tr><td>$ActivationPriceLabe</td><td class="uk-text-right">CHF $getFees<% if Quantity > 1 %> * $Quantity<% end_if %></td></tr>
			<% end_if %>
		<% end_loop %>
		<% end_if %>
		<% if $ExistingCustomer == 2 %>
		<tr><td>Aufschaltgebühr</td><td class="uk-text-right">$SiteConfig.ActivationPrice.Nice</td></tr>
		<% end_if %>
	</tbody>
	<tfoot>
		<tr><td>Total (einmalig)</td><td id="total-unique-price" class="uk-text-right uk-text-bold">$PrintUniquePrice</td></tr>
	</tfoot>
</table>
<% end_if %>
<div class="uk-margin-small">
	<a data-uk-toggle="#modal-conditions" data-uk-icon="chevron-right">Konditionen</a>
</div>
<%-- <div class="uk-margin-small">
	<div class="uk-flex uk-flex-middle">
		<img src="$ThemeDir/img/gift-solid.svg" class="uk-margin-small-right" width="50">
		<div>
			<strong>Aktion</strong><br>
			<small>3 Monate 1/2 Preis</small>
		</div>
	</div>
</div> --%>