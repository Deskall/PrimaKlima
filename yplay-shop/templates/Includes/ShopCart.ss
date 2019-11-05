<strong class="uk-text-small">Monatliche Kosten</strong>
								<table id="monthly-costs" class="uk-table uk-table-small uk-table-striped">
									<tbody>
										<% if Package.exists %>
										<% with Package %>
										<tr><td class="uk-table-expand">$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
										<% end_with %>
										<% end_if %>
										<% if Products.exists %>
										<% loop Products %>
										<tr><td class="uk-table-expand">$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
										<% end_loop %>
										<% end_if %>
									</tbody>
									<tfoot>
										<tr><td class="uk-table-expand">Total (monatlich)</td><td id="total-monthly-price" class="uk-text-right uk-text-lead uk-strong">$TotalMonthlyPrice</td></tr>
									</tfoot>
								</table>
								<strong class="uk-text-small">Einmalige Kosten</strong>
								<table id="unique-costs" class="uk-table uk-table-small uk-table-striped">
									<tbody>
										<% if Package %>
										<% with Package %>
											<% if UniquePrice > 0 %>
												<tr><td class="uk-table-expand">$UniquePriceLabel</td><td class="uk-text-right">CHF $UniquePrice</td></tr>
											<% end_if %>
											<% if ActivationPrice > 0 %>
												<tr><td class="uk-table-expand">$ActivationPriceLabel</td><td class="uk-text-right">CHF $ActivationPrice</td></tr>
											<% end_if %>
										<% end_with %>
										<% end_if %>
										<% if Products.exists %>
										<% loop Products %>
											<% if UniquePrice > 0 %>
												<tr><td class="uk-table-expand">$UniquePriceLabel</td><td class="uk-text-right">CHF $UniquePrice</td></tr>
											<% end_if %>
											<% if ActivationPrice > 0 %>
												<tr><td class="uk-table-expand">$ActivationPriceLabel</td><td class="uk-text-right">CHF $ActivationPrice</td></tr>
											<% end_if %>
										<% end_loop %>
										<% end_if %>
									</tbody>
									<tfoot>
										<tr><td class="uk-table-expand">Total (einmalig)</td><td id="total-unique-price" class="uk-text-right uk-text-lead uk-strong">$TotalUniquePrice</td></tr>
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