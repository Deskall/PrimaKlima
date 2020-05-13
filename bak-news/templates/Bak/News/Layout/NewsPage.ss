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
									<div class="uk-width-1-3 uk-text-center">
										<% if Image %><img src="$Image.FitMax(250,150).URL" /><% end_if %>
									</div>
									<div class="uk-width-2-3">
										<h3>$Title</h3>
										<% if $Lead %>
										$Lead.LimitWordCount(50)
										<% else %>
										$Content.LimitWordCount(50)
										<% end_if %>
										<div class="uk-text-right">
											<a href="$Link"><%t News.WEITER 'weiterlesen' %><span data-uk-icon="icon:chevron-right;ratio:0.8"></span></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr>
					</div>
					<% end_loop %>
				</div>
			</div>
		</section>
	</div>