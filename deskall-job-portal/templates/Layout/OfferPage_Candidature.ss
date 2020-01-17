<section class="uk-section uk-section-small">
	<div class="uk-container">
		<div class="uk-margin">
			<div><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="icon icon-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div>
		</div>
		<h1>$Title</h1>
		<% with Candidature %>
		<div class="uk-margin">
			<div class="uk-card uk-card-body">
				<div class="uk-flex uk-flex-middle" data-uk-grid>
					<% if $Candidat.Picture %>
					<div class="uk-width-auto company-logo">
						$Candidat.Thumbnail
					</div>
					<% end_if %>
					<div class="uk-width-expand">
						<strong>$Candidat.Gender $Candidat.Member.FirstName $Candidat.Member.Surname</strong><br/>
						<span>$Candidat.Age</span>
						$Description
					</div>
					<div class="uk-width-auto candidat-address uk-text-right">
						$Candidat.NiceAddress
					</div>
				</div>
			</div>
		</div>
		<% if $Content %>
		<hr>
		<div class="uk-margin">
			<div class="uk-card uk-card-body">
				<h2><%t Candidature.Text 'Bewerbungstext' %></h2>
				$Content
			</div>
		</div>
		<% end_if %>
		<hr>
		<div class="uk-margin">
			<div class="uk-card uk-card-body">
				<h2><%t Candidature.ExperienceTitle 'Berüfliche Erfahrungen' %></h2>
				<% loop $Candidat.CVItems %>
					<div data-uk-grid>
						<div class="uk-width-1-3 uk-width-1-4@m uk-width-1-5@l">
							<p><small>$StartDate.Nice - <% if $EndDate %>$EndDate.Nice<% else %><%t Candidature.Today 'Heute' %><% end_if %></small></p>
							<p>$Company</p>
						</div>
						<div class="uk-width-2-3 uk-width-3-4@m uk-width-4-5@l">
							<strong>$Position</strong>
							$Description
						</div>
					</div>
				<% end_loop %>
			</div>
		</div>
		<hr>
		<div class="uk-margin">
			<div class="uk-card uk-card-body">
				<h2><%t Candidature.FormationTitle 'Ausbildungen' %></h2>
				<% loop $Candidat.CursusItems %>
					<div data-uk-grid>
						<div class="uk-width-1-3 uk-width-1-4@m uk-width-1-5@l">
							<p><small>$StartDate.Nice - <% if $EndDate %>$EndDate.Nice<% else %><%t Candidature.Today 'Heute' %><% end_if %></small></p>
						</div>
						<div class="uk-width-2-3 uk-width-3-4@m uk-width-4-5@l">
							<strong>$Diplom</strong>
							<p>$School</p>
						</div>
					</div>
				<% end_loop %>
			</div>
		</div>
		<hr>
		<div class="uk-margin">
			<div class="uk-flex uk-flex-center uk-flex-around">
				<a href="mailto:$Email" class="uk-button button-PrimaryBackground"><%t Candidature.Answer 'Kontakt aufnehmen' %></a>
				<a data-uk-toggle="#refusal-modal" class="uk-button uk-button-default"><%t Candidature.Decline 'Bewerbung ablehnen' %></a>
			</div>
		</div>
		<% end_with %>
	</div>
</section>

