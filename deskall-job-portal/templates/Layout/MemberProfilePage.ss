<% if ID < 0 || $firstBlockSlide %>
<% include DefaultSlide %>
<% end_if %>

$ElementalArea

$activeTab

<div class="element uk-background-cover" id="member-section">
	<section class="uk-section uk-section-xsmall">
		<div class="uk-container">
					<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
						<li <% if not $activeTab || $activeTab == "account" %>class="active"<% end_if %>><a><%t JobGiver.Account '1. Adressangaben erfassen' %></a></li>
						<li <% if $activeTab == "profil" %>class="active"<% end_if %>><a><%t JobGiver.Profil '2. Firmenporträt erstellen' %></a></li>
						<li <% if $activeTab == "payment" %>class="active"<% end_if %>><a><%t JobGiver.Payment '3. Paket bestellen' %></a></li>
						<li <% if $activeTab == "offers" %>class="active"<% end_if %>><a><%t JobGiver.Offers '4. Inserate erstellen' %></a></li>
						<li <% if $activeTab == "ads" %>class="active"<% end_if %>><a><%t JobGiver.Ads '4. Bewerbungen verwalten' %></a></li>
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
