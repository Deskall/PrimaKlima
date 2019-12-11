<% if ID < 0 || $firstBlockSlide %>
<% include DefaultSlide %>
<% end_if %>

$ElementalArea

<div class="element uk-background-cover" id="member-section">
	<section class="uk-section uk-section-xsmall">
		<div class="uk-container">
					<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
						<li><a><%t JobGiver.Offers 'Ihre Stellenanzeigen' %></a></li>
						<li class="uk-active"><a><%t JobGiver.Profil 'Firmen Porträt' %></a></li>
						<li><a><%t JobGiver.Account 'Ihr Konto' %></a></li>
					</ul>
				
					<ul id="component-tab" class="uk-switcher" data-uk-height-match="target: .account-tab;row: false;">
						<li class="account-tab">
							<div class="uk-panel">
								<h2 class="uk-heading-divider"><%t JobGiver.Offers 'Ihre Stellenanzeigen' %></h2>
								<div class="member-section-container">
									
								</div>
							</div>
						</li>
						<li class="account-tab personal-data-tab">
							<div class="uk-panel">
								<h2 class="uk-heading-divider"><%t JobGiver.Profil 'Ihre Profil' %></h2>
								<div class="member-section-container">
								$ProfilForm
								</div>
							</div>
						</li>
						<li class="account-tab">
							<div class="uk-panel">
								<h2 class="uk-heading-divider"><%t JobGiver.Account 'Ihr Konto' %></h2>
								<div class="member-section-container">
									$AccountForm
								</div>
							</div>
						</li>
					</ul>
				
		</div>
	</section>
</div>
