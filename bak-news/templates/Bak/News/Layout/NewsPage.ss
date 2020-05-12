	$ElementalArea

	<div class="element  baknewsblocks" id="baknewsblock">
		<section class="uk-section uk-section-small">
			<div class="uk-container">
				<div data-uk-grid>
					<% loop News %>
					<div>
						<div class="uk-card">
							<div class="uk-card-content">
								<h3>$Title</h3>
								$Lead.LimitWirdCount(20)
							</div>
						</div>
					</div>
					<% end_loop %>
				</div>
			</div>
		</section>
	</div>