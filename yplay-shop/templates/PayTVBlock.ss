<% include TextBlock %>

<div class="uk-margin">
	<% if PayTVPackages.exists %>
	<div class="uk-overflow-auto pay-tv-packages-container $Height"> 
		
		<table class="uk-table uk-table-small uk-table-divider uk-table-striped">
			<tbody>
			<% loop PayTVPackages %>
			<tr class="product" data-price="$getMonthlyPrice" data-value="$ProductCode">
				<td><input type="checkbox" class="uk-checkbox" name="$ProductCode" <% if getMonthlyPrice == 0 %>checked readonly disabled<% end_if %>></td>
				<td><% if BestSeller %><div class="uk-flex uk-flex-middle"><span>$Title</span><span class="uk-label uk-margin-left">Besteller</span></div><% else %>$Title<br><% end_if %><small class="uk-visible@m">$Subtitle</small></td>
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
			<a class="uk-button dk-button" data-submit-paytv>Jetzt bestellen</a>
		</div>
	</div>
	<% else %>
	<p><i>Zurzeit keine Premium-Pakete verfügbar</i></p>
	<% end_if %>
</div>