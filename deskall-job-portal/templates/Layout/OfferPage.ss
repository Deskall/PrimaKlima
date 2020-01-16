	<% if Content %>
	<section class="uk-section uk-section-small no-bg">
		<div class="uk-container">
			<h1>$Title</h1>
			<div class="dk-text-content">$Content</div>
		</div>
	</section>
	<% else %>
	<div class="element offer-page">
		<section class="uk-section uk-section-small">
			<div class="uk-container">
				<h1>$Title</h1>
				<div class="uk-grid-match" data-uk-grid>
					<div class="uk-visible@m uk-width-1-4@m uk-width-1-5@l">
						<% include OfferPageSidebar %>
					</div>
					<div class="uk-width-1-1 uk-width-3-4@m uk-width-4-5@l">
						<% include FilteredOffers %>
					</div>
				</div>
			</div>
		</section>
	</div>
	<% end_if %>