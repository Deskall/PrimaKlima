<section class="uk-section uk-section-small">
	<div class="uk-container">

				<% with Offer.Customer %>
				<div class="company-header">
					<div class="uk-card uk-card-default uk-card-body">
						<div class="uk-flex uk-flex-middle" data-uk-grid>
							<% if Logo %>
							<div class="uk-width-auto company-logo">
								<img src="$Logo.URL" alt="Logo von $Company" width="250">
							</div>
							<% end_if %>
							<div class="uk-width-expand company-address">
								<p>
									<strong>$Company</strong><br>
									$Address<br>
									$PostalCode - $City<br>
									$NiceCountry
								</p>
							</div>
						</div>
					</div>
				</div>
				<% end_with %>
				<% with Offer %>
				<div class="main-body-offer">
					<h1>$Title</h1>
					$Description
					$Customer.Description
					$Customer.ReasonWhy
				</div>
				<% end_with %>
			
	</div>
</section>