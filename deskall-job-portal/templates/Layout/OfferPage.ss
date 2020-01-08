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
						<div class="parameter uk-margin">
							<strong class="parameter-title"><%t JobSearch.Places 'Ort' %></strong>
							<% loop $CookConfig.activeCountries.GroupedBy(CountryTitle) %>
								<div class="uk-flex uk-flex-between"><span class="uk-text-truncate">$CountryTitle</span><span>$Children.count</span></div>
							<% end_loop %>
						</div>
					</div>
				</div>
				<div class="uk-width-1-1 uk-width-3-4@m uk-width-4-5@l">
					<div class="offers-container">
						<p id="count-offers">$activeOffers.count</p>
						<div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
						<% loop activeOffers %>
						<div>
							<div class="uk-card uk-card-body uk-card-small offer-snippet">
								<div class="uk-grid-small" data-uk-grid>
									<div class="uk-width-1-5">
										<div class="firma-logo">
											<img <% if $Customer.Logo.getExtension == "svg" %>src="$Customer.Logo.URL" class="svg-logo"<% else %>src="$Customer.Logo.Fit(150,150).URL"<% end_if %> alt="Logo von $Company" width="150" height="150">
										</div>
									</div>
									<div class="uk-width-3-5">
										<div><a href="$previewLink" title="Stelle ansehen"><strong>$Title</strong></a></div>
										<div><i>$Customer.Company</i></div>
										<div class="uk-flex uk-grid uk-text-small uk-margin-small-top">
											<div class="place"><i class="icon icon-location uk-margin-small-right"></i>$City</div>
											<% with Parameters.filter('Title','Anstellung').first %><div class="type"><i class="icon icon-information uk-margin-small-right"></i>$Value</div><% end_with %>
											<div class="start"><i class="icon icon-calendar uk-margin-small-right"></i>$PublishedDate.Nice</div>
										</div>
									</div>
									<div class="uk-width-1-5">
									</div>
								</div>
							</div>
						</div>
						<% end_loop %>
						</div>
						
						<% if $activeOffers.MoreThanOnePage %>
						<ul class="uk-pagination uk-flex-center">
						    <% if $activeOffers.NotFirstPage %>
						        <li><a class="prev" href="$activeOffers.PrevLink"><span data-uk-pagination-previous></span></a></li>
						    <% end_if %>
						    <% loop $activeOffers.PaginationSummary %>
						        <% if $CurrentBool %>
						             <li class="uk-active"><span>$PageNum</span></li>
						        <% else %>
						            <% if $Link %>
						                <li><a href="$Link">$PageNum</a></li>
						            <% else %>
						                 <li class="uk-disabled"><span>...</span></li>
						            <% end_if %>
						        <% end_if %>
						    <% end_loop %>
						    <% if $activeOffers.NotLastPage %>
						        <li><a class="next" href="$activeOffers.NextLink"><span data-uk-pagination-next></span></a></li>
						    <% end_if %>
						</ul>
						<% end_if %>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>