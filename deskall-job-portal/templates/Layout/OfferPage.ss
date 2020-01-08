<div class="element">
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<div class="uk-grid-match" data-uk-grid>
				<div class="uk-visible@m uk-width-1-4@m uk-width-1-5@l">
					<div class="sidebar">
						<h1 class="uk-h3">$Title</h1>
					</div>
				</div>
				<div class="uk-width-1-1 uk-width-3-4@m uk-width-4-5@l">
					<div class="offers-container">
						<p id="count-offers">$activeOffers.count</p>
						<div class="uk-width-1-1" data-uk-grid>
						<% loop activeOffers %>
						<div>
							<strong>$Title</strong>
						</div>
						<% end_loop %>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>