
		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>
		<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
			<div data-uk-height-match="target:.dk-box-content .box-text;">
				<div class="uk-child-width-1-2@s uk-child-width-1-4@l uk-grid-medium" data-uk-grid data-uk-height-match="target:img;row:false;">
					<% loop ActiveBoxes %>
					
					<div class="box uk-transition-toggle uk-height-1-1" tabindex="0">
		   				<a href="$Category.Link">
							<h3 class="uk-margin">$Category.Title</h3>
							<div class="uk-margin-top dk-box-content">
						    	<div class="box-text"><%t ProductOverviewPage.PRODUKTE "Passende Produkte" %> <span class="icon ion-ios-arrow-right"></span></div>
						    </div>
						    <% if $Category.Image %>
						    	<div class="uk-flex uk-flex-center uk-flex-middle">
						    		<img class="dk-icon uk-width-auto" src="$Category.Image.Fit(300,300).URL" />
						    	</div>
						    <% end_if %>
						</a>
					</div>
					
					<% end_loop %>
				</div>
			</div>
		</div>