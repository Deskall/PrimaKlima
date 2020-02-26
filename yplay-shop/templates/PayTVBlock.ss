<% include TextBlock %>

<div class="uk-margin">
	<% if PayTVPackages.exists %>
	<div class="uk-overflow-auto uk-height-medium"> 
		
		<table class="uk-table uk-table-small uk-table-divider uk-table-striped">
			<tbody>
			<% loop PayTVPackages %>
			<tr class="product" data-price="$getMonthlyPrice" data-value="$ProductCode">
				<td><input type="checkbox" class="uk-checkbox" name="$ProductCode"></td>
				<td>$Title<br><small class="uk-visible@m">$Subtitle</small></td>
				<td class="uk-table-shrink uk-text-nowrap">$PrintPriceString</td>
			</tr>
			<% end_loop %>
			</tbody>
		</table>
	</div>
	<div class="uk-margin">
		<div class="uk-text-right">
			<a class="uk-button" data-submit-paytv>Jetzt bestellen</a>
		</div>
	</div>
	<% else %>
	<p><i>Zurzeit keine Premium-Pakete verfügbar</i></p>
	<% end_if %>
</div>