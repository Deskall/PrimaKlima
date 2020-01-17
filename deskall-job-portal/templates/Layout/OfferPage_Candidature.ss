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
						<img src="$Candidat.Picture.ScaleWidth(150).URL" alt="Foto von $Candidat.Title" width="150">
					</div>
					<% end_if %>
					<div class="uk-width-expand company-address">
						<strong>$Candidat.Title</strong><br>
					</div>
				</div>
			</div>
		</div>
		<% end_with %>
	</div>
</section>

