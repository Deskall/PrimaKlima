	$ElementalArea

	<div class="element  baknewsblocks" id="baknewsblock">
		<section class="uk-section uk-section-small">
			<div class="uk-container">
				<div class="uk-child-width-1-1" data-uk-grid>
					<% loop NewsList %>
					<div>
						<div class="uk-card">
							<div class="uk-card-content">
								<div class="uk-grid-small" data-uk-grid>
								<div class="uk-width-1-3">
									<% if Image %><img src="$Image.FocusFillMax(350,250).URL" /><% end_if %>
								</div>
								<div class="uk-width-2-3">
									<h3>$Title</h3>
									<% if $Lead %>
									$Lead.LimitWordCount(20)
									<% else %>
									$Content.LimitWordCount(20)
									<% end_if %>
								</div>
							</div>
						</div>
					</div>
					<% end_loop %>
				</div>
			</div>
		</section>
	</div>