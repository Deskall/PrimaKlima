<div class="element offer-page">
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<div class="uk-grid-match" data-uk-grid>
				<div class="uk-visible@m uk-width-1-4@m uk-width-1-5@l">
					<div class="sidebar">
						<h1 class="uk-h3">$Title</h1>
						<% loop $CookConfig.Parameters %>
							<div class="parameter uk-margin">
								<strong class="parameter-title">$Title</strong>
								<% loop $Values %>
								<% if $activeOffers.exists %>
								<div class="uk-flex uk-flex-between"><span class="uk-text-truncate">$Title</span><span>$activeOffers.count</span></div>
								<% end_if %>
								<% end_loop %>
							</div>
						<% end_loop %>
					</div>
				</div>
				<div class="uk-width-1-1 uk-width-3-4@m uk-width-4-5@l">
					<div class="offers-container">
						<p id="count-offers">$activeOffers.count</p>
						<div class="uk-child-width-1-1" data-uk-grid>
						<% loop activeOffers %>
						<div>
							<div class="uk-card uk-card-hover uk-card-body">
								<div class="uk-grid-small" data-uk-grid>
									<div class="uk-width-1-5">
										<div class="firma-logo">
											<img src="$Customer.Logo.FitMax(150,150).URL" alt="Logo von $Company" width="150" height="150">
										</div>
									</div>
									<div class="uk-width-3-5">
										<div class="uk-text-bold">$Title</div>
										<div><i>$Customer.Company</i></div>
										<div class="uk-flex uk-grid uk-text-small">
											<div class="place">$City</div>
											<% with Parameters.filter('Title','Anstellung').first %><div class="type">$Value</div><% end_with %>
											<div class="start">$Start.Nice</div>
											<div class="uk-flex-right">$PublishedDate.NiceDate</div>
										</div>
									</div>
									<div class="uk-width-1-5">
									</div>
								</div>
							</div>
						</div>
						<% end_loop %>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>