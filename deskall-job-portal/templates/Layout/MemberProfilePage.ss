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
									<div class="uk-margin">
										<% if CurrentCustomer.activeOrder %>
										<h4><%t MemberPage.MoreTitle 'Inserate verfügbar' %></h4>
										<p><%t MemberPage.OffersAvailable 'Ihr Abonnement ist aktiv, Sie durfen Inserate jetzt freischalten!' %></p>
										<table class="uk-table uk-table-small uk-table-justify">
											<thead></th><th><%t MemberPage.OrdersTableTH2 'Paket' %></th><th><%t MemberPage.OrdersTableTH2 'Gültig bis' %></th><th><%t MemberPage.OrdersTableTH3 'Verbleibende Anzeige' %></th></thead>
											<tbody>
											<% with CurrentCustomer.activeOrder %>
											<tr><td class="uk-table-expand"><%t MemberPage.Package 'Paket' %> $Product.Title</td><td>$EndValidity.Nice</td><td>$RemainingOffers</td></tr>
											<% end_with %>
											</tbody>
										</table>
										<% else %>
											<h4><%t MemberPage.NoMoreTitle 'Keine Inserate verfügbar' %></h4>
											<% if CurrentCustomer.stagedOrder %>
											<p><%t MemberPage.waitingPayment 'Achtung, Sie können derzeit keine neuen Inserate mehr schalten, da Sie noch unbezahlte Rechnungen offen haben.<br>Sobald diese bezahlt sind, können Sie Ihre Inserate freischatlen.' %></p>
											<% else %>
											<p><%t MemberPage.NoMore 'Achtung, Sie können derzeit keine neuen Inserate mehr schalten.<br>Bestellen Sie ein neues Paket, um neuen Inserate zu freischatlen.' %></p>
											<a class="uk-button uk-button-primary" href="$ShopPage.Link"><%t Payment.OrderPackage 'jetzt Paket bestellen' %></a>
											<% end_if %>
										<% end_if %>
									</div>
									<% if CurrentCustomer.Orders.exists %>
									<div class="uk-margin uk-overflow-auto">
										<h4><%t MemberPage.OrdersTitle 'Meine Bestellungen' %></h4>
										<table class="uk-table uk-table-small uk-table-justify">
											<thead></th><th><%t MemberPage.OrdersTableTH2 'Paket' %></th><th><%t MemberPage.OrdersTableTH2 'Laufzeit' %></th><th><%t MemberPage.OrdersTableTH3 'Anzahl Anzeige' %></th><th><%t MemberPage.OrdersTableTH1 'Zeitraums' %><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></thead>
											<tbody>
											<% loop CurrentCustomer.Orders %>
											<tr><td class="uk-table-expand"><%t MemberPage.Package 'Paket' %> $Product.Title</td><td>$Product.RunTimeTitle</td><td>$Product.NumOfAdsTitle</td><td>$Period</td><td><% if isPaid %>bezahlt<% else %>nicht bezahlt<% end_if %></td><td>$Status</td><td>$Documents</td></tr>
											<% end_loop %>
											</tbody>
										</table>
									</div>
									<% end_if %>
								</div>
							</div>
						</li>
						<li class="account-tab">
							<div class="uk-panel uk-background-muted uk-padding-small">
								<h2><%t JobGiver.OffersTitle 'Inserate' %></h2>
								<div class="member-section-container">
									$OffersTabHTML
								</div>
								<div class="toggle-new-offer">
									<% if CurrentCustomer.activeOrder %>
									<a class="uk-button uk-button-primary" data-uk-toggle=".toggle-new-offer"><%t Offer.Create 'jetzt neu Inserat erfassen' %></a>
									<% else %>
									<p><%t MemberPage.CannotPublish 'Sie können derzeit keine Inserate freischalten. Sie können aber dennoch Inserate als Entwurf erfassen und zu einem späteren Zeitpunkt freischalten.' %></p>
									<% end_if %>
									<% if CurrentCustomer.Offers.exists %>
									<div class="uk-margin uk-overflow-auto">
										<h4><%t MemberPage.OffersTitle 'Meine Inserate' %></h4>
										<table class="uk-table uk-table-small uk-table-justify">
											<thead></th><th><%t MemberPage.OffersTableTH2 'Titel' %></th><th><%t MemberPage.OffersTableTH2 'Schaltungsdauer' %></th><th><%t MemberPage.OffersTableTH3 'Anzahl Bewerbungen' %></th><th><%t MemberPage.OffersTableTH1 'Status' %><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></thead>
											<tbody>
											<% loop CurrentCustomer.Offers %>
											<tr><td class="uk-table-expand">$Title</td><td>$RunTimeTitle</td><td>$Candidatures.count</td><td>$Status</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
											<% end_loop %>
											</tbody>
										</table>
									</div>
									<% end_if %>
								</div>
								<div id="offer-form-container" class="toggle-new-offer" hidden>
									<a class="uk-button uk-button-muted" data-uk-toggle="target:.toggle-new-offer"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></a>
									$JobOfferForm
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
