<section class="uk-section uk-section-small">
	<div class="uk-container">

				<% with Offer %>
				<div class="company-header">
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
								<div class="uk-flex uk-flex-stretch uk-text-small">
									<div class="place">$City</div>
									<div class="type">$Type</div>
									<div class="start">$Start.Date</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="main-body-offer">
					<div class="uk-card uk-card-default uk-card-body">
						$Description
						$Customer.Description
						$Customer.ReasonWhy
					</div>
				</div>
				<% end_with %>
			$Address<br>
									$PostalCode - $City<br>
									$NiceCountry
	</div>
</section>