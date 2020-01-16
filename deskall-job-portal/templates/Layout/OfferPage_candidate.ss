<section class="uk-section uk-section-small">
	<div class="uk-container">
		<% with Offer %>
		<div class="uk-margin company-header">
			<div class="uk-card uk-card-default uk-card-body">
				<div class="uk-flex uk-flex-middle" data-uk-grid>
					<% if Customer.Logo %>
					<div class="uk-width-auto company-logo">
						<img src="$Customer.Logo.URL" alt="Logo von $Customer.Company" width="250">
					</div>
					<% end_if %>
					<div class="uk-width-expand company-address">
						<strong>$Customer.Company</strong><br>
						<h1>$Title</h1>
						<div class="uk-flex uk-grid uk-text-small">
							<div class="place"><i class="icon icon-location uk-margin-small-right"></i>$City</div>
							<% with Parameters.filter('Title','Anstellung').first %><div class="type"><i class="icon icon-information uk-margin-small-right"></i>$Value</div><% end_with %>
							<div class="start"><i class="icon icon-calendar uk-margin-small-right"></i>$PublishedDate.Nice</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<% end_with %>
		<div class="uk-margin">
			<div><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="icon icon-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div>
			<div class="uk-margin">
				$ApplicationForm
			</div>
		</div>
	</div>
</section>

