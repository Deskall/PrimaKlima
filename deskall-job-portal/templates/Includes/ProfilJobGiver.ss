<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
								<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t JobGiver.Account '1. Adressangaben erfassen' %></a></li>
								<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t JobGiver.Profil '2. Firmenporträt erstellen' %></a></li>
								<li <% if $activeTab == "payment" %>class="uk-active"<% end_if %>><a><%t JobGiver.Payment '3. Paket bestellen' %></a></li>
								<li <% if $activeTab == "offers" %>class="uk-active"<% end_if %>><a><%t JobGiver.Offers '4. Inserate erstellen' %></a></li>
								<li <% if $activeTab == "ads" %>class="uk-active"<% end_if %>><a><%t JobGiver.Ads '5. Bewerbungen verwalten' %></a></li>
							</ul>
						
							<ul id="component-tab" class="uk-switcher">
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobGiver.AccountTitle 'Adressangaben' %></h2>
										<div class="member-section-container">
											$Portal.AccountTabHTML
											$AccountForm
										</div>
									</div>
								</li>
								<li class="account-tab personal-data-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobGiver.ProfilTitle 'Firmenporträt' %></h2>
										<div class="member-section-container">
											$Portal.ProfilTabHTML
											$ProfilForm
										</div>
									</div>
								</li>
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobGiver.PaymentTitle 'Pakete' %></h2>
										<div class="member-section-container">
											$Portal.PaymentTabHTML
											<div class="uk-margin">
												<% if CurrentCustomer.activeOrder %>
												<h4><%t MemberPage.MoreTitle 'Inserate verfügbar' %></h4>
												<p><%t MemberPage.OffersAvailable 'Ihr Abonnement ist aktiv, Sie durfen Inserate jetzt freischalten!' %></p>
												<table class="uk-table uk-table-small uk-table-justify uk-table-responsive">
													<thead></th><th><%t MemberPage.OrdersTableTH1 'Paket' %></th><th><%t MemberPage.OrdersTableTH4 'Gültig bis' %></th><th><%t MemberPage.OrdersTableTH5 'Verbleibende Anzeige' %></th></thead>
													<tbody>
													<% with CurrentCustomer.activeOrder %>
													<tr><td class="uk-table-expand"><%t MemberPage.Package 'Paket' %> $Product.Title</td><td><% if EndValidity %>$EndValidity.Nice<% else %>$Product.RunTime $Product.RunTimeCurrency <%t Order.EndValidityEmptyLabel 'nach Veröffentlichung Ihres ersten Angebots' %><% end_if %></td><td><% if $Product.NumOfAds > 0 %>$RemainingOffers<% else %>$Product.NumOfAdsTitle<% end_if %></td></tr>
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
												<table class="uk-table uk-table-small uk-table-justify uk-table-divider uk-table-responsive">
													<thead><th><%t MemberPage.OrdersTableTH1 'Paket' %></th><th><%t MemberPage.OrdersTableTH2 'Laufzeit' %></th><th><%t MemberPage.OrdersTableTH3 'Anzahl Anzeige' %></th><th><%t MemberPage.OrdersTableTH4 'Gültig bis' %><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></thead>
													<tbody>
													<% loop CurrentCustomer.Orders %>
													<tr><td class="uk-table-expand"><%t MemberPage.Package 'Paket' %> $Product.Title</td><td><% if Option %>$Option.Title<% else %>$Product.RunTimeTitle<% end_if %></td><td>$Product.NumOfAdsTitle</td><td><% if EndValidity %>$EndValidity.Nice<% else %>$Product.RunTime $Product.RunTimeCurrency <%t Order.EndValidityEmptyLabel 'nach Veröffentlichung Ihres ersten Angebots' %><% end_if %></td><td><% if isPaid %>bezahlt<% else %>nicht bezahlt<% end_if %></td><td>$Status</td><td>$Documents</td></tr>
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
											$Portal.OffersTabHTML
											<% if $AccountMessage %>
											<p id="account_message" class="message">$AccountMessage</p>
											<% end_if %>
										</div>
										<div class="toggle-new-offer">
											<a id="new-offer" class="uk-button uk-button-primary" data-uk-toggle=".toggle-new-offer"><%t Offer.Create 'jetzt neu Inserat erfassen' %></a>
											<% if not CurrentCustomer.activeOrder %>
											<p><%t MemberPage.CannotPublish 'Sie können derzeit keine Inserate freischalten. Sie können aber dennoch Inserate als Entwurf erfassen und zu einem späteren Zeitpunkt freischalten.' %></p>
											<% end_if %>
											<% if CurrentCustomer.Missions.exists %>
											<div class="uk-margin uk-overflow-auto">
												<h4><%t MemberPage.OffersTitle 'Meine Inserate' %></h4>
												<table class="uk-table uk-table-small uk-table-striped uk-table-justify uk-table-divider uk-table-responsive">
													<thead></th><th><%t MemberPage.OffersTableTH2 'Titel' %></th><th><%t MemberPage.OffersTableTH3 'Anzahl Bewerbungen' %></th><th><%t MemberPage.OffersTableTH1 'Status' %><th>&nbsp;</th></thead>
													<tbody>
													<% loop CurrentCustomer.Missions %>
													<tr><td class="uk-table-expand">$Title</td><td>$Candidatures.count <span class="uk-hidden@m uk-margin-left-small"><%t Mission.Candidatures 'Bewerbungen' %></span></td><td>$NiceStatus</td><td><a href="$previewLink" class="uk-margin-right"><i class="icon icon-eye"></i></a><% if canEdit %><a href="{$Top.Link}inserat-bearbeiten/{$ID}" class="uk-margin-right"><i class="icon icon-edit"></i></a><% end_if %><% if canDelete %><a data-uk-toggle="target: #modal-delete-offer-{$ID}" class="uk-margin-right"><i class="icon icon-trash-a"></i></a><% end_if %><% if canPublish %><a class="uk-button uk-button-small uk-button-primary" data-uk-toggle="target: #modal-publish-offer-{$ID}" title="<%t Mission.Publish 'Veröffentlichen' %>" data-uk-tooltip><i class="icon icon-ios-cloud-upload-outline"></i></a><% end_if %><% if canUnpublish %><a class="uk-button uk-button-secondary uk-button-small"  title="<%t Mission.UnPublish 'Parkieren' %>" data-uk-tooltip data-uk-toggle="target: #modal-unpublish-offer-{$ID}"><i class="icon icon-ios-cloud-download-outline"></i></a><% end_if %></td></tr>
													<div id="modal-delete-offer-{$ID}" data-uk-modal>
													    <div class="uk-modal-dialog">
													        <button class="uk-modal-close-default" type="button" data-uk-close></button>
													        <div class="uk-modal-body">
													        	<strong class="uk-modal-title"><%t MemberPage.DeleteOfferModalTitle 'Möchten Sie dieses Angebot wirklich löschen?' %></strong>
													        	<p><%t MemberPage.DeleteOfferModalBody 'Diese Löschung ist endgültig.' %></p>
														        <div class="uk-text-right">
														        	<button class="uk-button uk-button-default uk-modal-close" type="button"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></button>
														        	<a href="{$Top.Link}inserat-loeschen/{$ID}" class="uk-button uk-button-danger"><i class="uk-margin-small-right" data-uk-icon="trash"></i><%t MemberPage.DeleteOffer 'Ja, löschen' %></a>
														        </div>
														    </div>
													    </div>
													</div>
													<div id="modal-publish-offer-{$ID}" data-uk-modal>
													    <div class="uk-modal-dialog">
													        <button class="uk-modal-close-default" type="button" data-uk-close></button>
													        <div class="uk-modal-body">
													        	<strong class="uk-modal-title"><%t MemberPage.PublishOfferModalTitle 'Möchten Sie dieses Angebot wirklich veröffentlichen?' %></strong>
													        	<p><%t MemberPage.PublishOfferModalBody 'Sie können dieses Angebot nach seiner Veröffentlichung nicht mehr ändern.' %></p>
														        <div class="uk-text-right">
														        	<button class="uk-button uk-button-secondary uk-modal-close" type="button"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></button>
														        	<a href="{$Top.Link}inserat-veroeffentlichen/{$ID}" class="uk-button uk-button-primary"><i class="icon icon-ios-cloud-upload-outline uk-margin-small-right"></i><%t MemberPage.PublishOffer 'Ja, veröffentlichen' %></a>
														        </div>
														    </div>
													    </div>
													</div>
													<div id="modal-unpublish-offer-{$ID}" data-uk-modal>
													    <div class="uk-modal-dialog">
													        <button class="uk-modal-close-default" type="button" data-uk-close></button>
													        <div class="uk-modal-body">
													        	<strong class="uk-modal-title"><%t MemberPage.UnPublishOfferModalTitle 'Möchten Sie dieses Angebot wirklich parkieren?' %></strong>
													        	<p><%t MemberPage.UnPublishOfferModalBody 'Dieses Angebot wird nicht mehr sichtbar sein.' %></p>
														        <div class="uk-text-right">
														        	<button class="uk-button uk-button-secondary uk-modal-close" type="button"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></button>
														        	<a href="{$Top.Link}inserat-parkieren/{$ID}" class="uk-button uk-button-primary"><i class="icon icon-ios-cloud-download-outline uk-margin-small-right"></i><%t MemberPage.UnPublishOffer 'Ja, parkieren' %></a>
														        </div>
														    </div>
													    </div>
													</div>
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
										<div id="edit-form-container" hidden>
											
										</div>
									</div>
								</li>
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobGiver.AdsTitle 'Bewerbungen' %></h2>
										<div class="member-section-container">
											$Portal.AdsTabHTML
											<% if CurrentCustomer.Candidatures.exists %>
											<table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
												<thead>
													<th colspan="2"><%t Candidature.Candidat 'Bewerber' %></th>
													<th><%t Candidature.Mission 'Stelle' %></th>
													<th><%t Candidature.Date 'Datum' %></th>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
													<th>&nbsp;</th>
												</thead>
												<% loop CurrentCustomer.Candidatures %>
												<tr><td>$Candidat.Thumbnail</td><td>$Candidat.NiceAddress</td><td>$Mission.ShortDescription</td><td>$Created.Ago</td><td><a href="$Link" title="<%t Candidature.SeeCandidat 'Bewerbung ansehen' %>" class="icon icon-eye" data-uk-tooltip></a></td><td><a data-delete="$ID" data-uk-tooltip title="<%t Candidature.Decline 'Bewerbung ablehnen' %>" class="icon icon-trash-a"></a></td><td>$NiceStatus</td></tr>
												<% end_loop %>
											</table>
											<% else %>
											<p><i><%t JobGiver.noCandidatures 'Sie haben momentan keine Bewerbung' %></i></p>
											<% end_if %>
										</div>
									</div>
									<!-- delete modal -->
										<div id="delete-modal" data-uk-modal>
										    <div class="uk-modal-dialog uk-modal-body">
										        <h2 class="uk-modal-title"><%t Candidature.DeleteModalTitle 'Möchten Sie wirklich diese Bewerbung löschen?' %></h2>
										        <p class="uk-text-right">
										            <button class="uk-button uk-button-default uk-modal-close" type="button"><%t Global.Back 'Zurück' %></button>
										            <a class="uk-button uk-button-primary" title="<%t Candidature.Delete 'Ja, löschen' %>"><%t Candidature.Delete 'Ja, löschen' %></a>
										        </p>
										    </div>
										</div>
								</li>
							</ul>


