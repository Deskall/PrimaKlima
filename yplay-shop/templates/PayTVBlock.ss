<% include TextBlock %>

<div class="uk-margin">
	<% if PayTVPackages.exists %>
	<table class="uk-table uk-table-small uk-table-divider uk-table-striped">
		<tbody>
		<% loop PayTVPackages %>
		<tr class="product" data-price="$getMonthlyPrice" data-value="$ProductCode">
			<td><input type="checkbox" class="uk-checkbox" name="$ProductCode"></td>
			<td>$Title<br><small class="uk-visible@m">$Subtitle</small></td>
			<td class="uk-table-shrink">$PrintPriceString</td>
		</tr>
		<% end_loop %>
		</tbody>
		<tbody>
	</table>
	<div class="uk-margin">
		<div class="uk-text-right">
			<a class="uk-button" data-submit-paytv>Jetzt bestellen</a>
		</div>
	</div>
	<% else %>
	<p><i>Zurzeit keine Premium-Pakete verfügbar</i></p>
	<% end_if %>
</div>