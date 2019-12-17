<section class="uk-section uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-width-1-5@l">
			</div>
			<div class="uk-width-3-4@m uk-width-4-5@l">
				<% with Offer.Customer %>
				<div class="company-header">
					<div class="uk-grid-small uk-flex uk-flex-middle" data-uk-grid>
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
				<% end_with %>
			</div>
		</div>
	</div>
</section>