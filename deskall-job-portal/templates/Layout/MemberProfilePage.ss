<% if ID < 0 || $firstBlockSlide %>
<% include DefaultSlide %>
<% end_if %>

$ElementalArea

<div class="element uk-background-cover" id="member-section">
	<section class="uk-section uk-section-xsmall">
		<div class="uk-container">
					<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
						<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t JobGiver.Account '1. Adressangaben erfassen' %></a></li>
						<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t JobGiver.Profil '2. Firmenporträt erstellen' %></a></li>
						<li <% if $activeTab == "payment" %>class="uk-active"<% end_if %>><a><%t JobGiver.Payment '3. Paket bestellen' %></a></li>
						<li <% if $activeTab == "offers" %>class="uk-active"<% end_if %>><a><%t JobGiver.Offers '4. Inserate erstellen' %></a></li>
						<li <% if $activeTab == "ads" %>class="uk-active"<% end_if %>><a><%t JobGiver.Ads '4. Bewerbungen verwalten' %></a></li>
					</ul>
				
					<ul id="component-tab" class="uk-switcher">
						<li class="account-tab">
							<div class="uk-panel uk-background-muted uk-padding-small">
								<h2><%t JobGiver.AccountTitle 'Adressangaben' %></h2>
								<div class="member-section-container">
									$AccountTabHTML
									$AccountForm
								</div>
							</div>
						</li>
						<li class="account-tab personal-data-tab">
							<div class="uk-panel uk-background-muted uk-padding-small">
								<h2><%t JobGiver.ProfilTitle 'Firmenporträt' %></h2>
								<div class="member-section-container">
									$ProfilTabHTML
									$ProfilForm
								</div>
							</div>
						</li>
						<li class="account-tab">
							<div class="uk-panel uk-background-muted uk-padding-small">
								<h2><%t JobGiver.PaymentTitle 'Pakete' %></h2>
								<div class="member-section-container">
									$PaymentTabHTML
									<% if activeOrder %>
									
									<% else %>
									<div class="uk-margin">
										<h4><%t MemberPage.NoMoreTitle 'Keine Inserate verfügbar' %></h4>
										<p><%t MemberPage.NoMore 'Achtung, Sie können derzeit keine neuen Inserate mehr schalten, da Sie noch unbezahlte Rechnungen offen haben.<br>Sobald diese bezahlt sind, können Sie Ihre Inserate freischatlen.' %></p>
										<a class="uk-button uk-button-primary" href="$ShopPage.Link"><%t Payment.OrderPackage 'jetzt Paket bestellen' %></a>
									</div>
									<% end_if %>
									<div class="uk-margin uk-overflow-auto">
										<h4><%t MemberPage.OrdersTitle 'Meine Bestellungen' %></h4>
										<table class="uk-table uk-table-small uk-table-justify">
											<% loop CurrentCustomer.Orders %>
											<tr><td class="uk-table-shrink">$Created.Date</td><td class="uk-table-expand"><%t MemberPage.Package 'Paket' %> $Product.Title</td><td>$Product.RunTimeTitle</td><td>$Product.NumOfAdsTitle</td><td><% if isPaid %>bezahlt<% else %>nicht bezahlt<% end_if %></td><td>$Status</td></tr>
											<% end_loop %>
										</table>
									</div>
								</div>
							</div>
						</li>
						<li class="account-tab">
							<div class="uk-panel uk-background-muted uk-padding-small">
								<h2><%t JobGiver.OffersTitle 'Inserate' %></h2>
								<div class="member-section-container">
									$OffersTabHTML
								</div>
							</div>
						</li>
						<li class="account-tab">
							<div class="uk-panel uk-background-muted uk-padding-small">
								<h2><%t JobGiver.AdsTitle 'Bewerbungen' %></h2>
								<div class="member-section-container">
									$AdsTabHTML
								</div>
							</div>
						</li>
					</ul>
		</div>
	</section>
</div>
