<% if ID < 0 || $firstBlockSlide %>
<% include DefaultSlide %>
<% end_if %>


<div class="element uk-background-cover" id="member-section">
	<section class="uk-section uk-section-xsmall">
		<div class="uk-container">
			<h1>$Title</h1>
			<div data-uk-grid>
				<div class="uk-width-auto@m">
					<ul class="uk-tab-left uk-margin-large-bottom" data-uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
						<li><a><%t JobGiver.Profil 'Firmen Porträt' %></a></li>
						<li><a><%t JobGiver.Offers 'Ihre Stellenanzeigen' %></a></li>
						<li><a><%t JobGiver.Account 'Ihr Konto' %></a></li>
					</ul>
				</div>
				<div class="uk-width-expand@m">
					<ul id="component-tab-left" class="uk-switcher" data-uk-height-match="target: .account-tab;row: false;">
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
								<h2 class="uk-heading-divider"><%t JobGiver.Offers 'Ihre Stellenanzeigen' %></h2>
								<div class="member-section-container">
									
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
			</div>
		</div>
	</section>
</div>
