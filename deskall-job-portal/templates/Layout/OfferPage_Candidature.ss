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
						<% if $Candidat.Birthdate %><span>$Candidat.Age</span><% end_if %>
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
				<i>$Content</i>
			</div>
		</div>
		<% end_if %>
		<hr>
		<% if CV.exists %>
		<div class="uk-margin">
			<div class="uk-card uk-card-body">
				<h2><%t Candidature.CVTitle 'Lebenslauf' %></h2>
				<p><%t Candidature.ShowCV 'Konsultieren Sie das Lebenslauf' %></p>
				<a href="$CV.URL" target="_blank" class="uk-button uk-background-muted"><i class="icon icon-file-pdf-o uk-margin-small-right"></i>$CV.Name</a>
			</div>
		</div>
		<% else %>
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
		<% end_if %>
		<hr>
		<div class="uk-margin">
			<div class="uk-flex uk-flex-center uk-flex-around">
				<% if Status == "declined" %>
				<p><%t Candidature.WasDeclined 'Diese Bewerbung wurde abgelehnt' %></p>
				<% else %>
				<a href="mailto:{$Candidat.Email}?subject=<%t Candidature.ContactMailTilte 'Ihre Bewerbung für die Stellenangebot' %> {$Mission.Nummer}  - $Top.SiteConfig.Title" class="uk-button button-PrimaryBackground"><i class="icon icon-ios-paperplane uk-margin-small-right"></i><%t Candidature.Answer 'Kontakt aufnehmen' %></a>
				<% if canDecline %><a data-uk-toggle="#decline-modal" class="uk-button uk-button-default"><i class="icon icon-ios-close-outline uk-margin-small-right"></i><%t Candidature.Decline 'Bewerbung ablehnen' %></a><% end_if %>
				<% end_if %>
			</div>
		</div>
		<% end_with %>
	</div>
</section>
<!-- Candidate modal -->
	<div id="decline-modal" data-uk-modal>
	    <div class="uk-modal-dialog uk-modal-body">
	        <h2 class="uk-modal-title"><%t Candidature.DeclineModalTitle 'Möchten Sie wirklich diese Bewerbung ablehnen?' %></h2>
	        <p><%t Candidature.DeclineModalBody 'Der Bewerber wird umgehend per E-Mail informiert.' %></p>
	        <form method="POST" action="{$Top.Link}bewerbung-ablehnen" class="form-std">
	        	<div>
	        		<label class="uk-form-label"><strong><%t Candidature.DeclineReason 'Ihre Nachricht an den Bewerber' %></strong></label>
	        		<div class="uk-form-controls">
	        			<textarea class="uk-textarea" rows="5" name="message"><%t Candidature.DeclineReasonBody 'Vielen Dank für Ihre Bewerbung, die Sie an uns gesendet haben. Nach sorgfältiger Prüfung müssen wir Ihnen leider mitteilen, dass wir keine Maßnahmen ergreifen.' %></textarea>
	        			<input type="hidden" name="CandidatureID" value="$Candidature.ID">
	        		</div>
	        	</div> 
		        <p class="uk-text-right">
		            <button class="uk-button uk-button-default uk-modal-close" type="button"><%t Global.Cancel 'Abbrechen' %></button>
		            <button type="submit" class="uk-button uk-button-primary"><%t Candidature.Decline 'Bewerbung ablehnen' %></button>
		        </p>
		    </form>
	    </div>
	</div>
