<% include TextBlock %>

<div class="uk-margin">
	<% if PayTVPackages.exists %>
	<div class="uk-overflow-auto pay-tv-packages-container"> 
		
		<table class="uk-table uk-table-small uk-table-divider uk-table-striped">
			<tbody>
			<% loop PayTVPackages %>
			<tr class="product" data-price="$getMonthlyPrice" data-value="$ProductCode">
				<td><% if getMonthlyPrice > 0 %><input type="checkbox" class="uk-checkbox" name="$ProductCode"><% end_if %></td>
				<td>$Title<br><small class="uk-visible@m">$Subtitle</small></td>
				<td class="uk-table-shrink uk-text-nowrap">$PrintPriceString</td>
			</tr>
			<% end_loop %>
			</tbody>
			<tfoot>
				<tr><td>&nbsp;</td><td class="uk-text-right uk-text-bold">Gesamtpreise</td><td id="total-price" class="uk-text-right uk-text-nowrap uk-text-bold">CHF 0.00 / Mt.</td></tr>
			</tfoot>
		</table>
	</div>
	<div class="uk-margin">
		<div class="uk-text-right">
			<a class="uk-button uk-button-primary" data-submit-paytv>Jetzt bestellen</a>
		</div>
	</div>
	<% else %>
	<p><i>Zurzeit keine Premium-Pakete verfügbar</i></p>
	<% end_if %>
</div>