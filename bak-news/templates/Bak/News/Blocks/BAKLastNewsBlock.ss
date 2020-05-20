		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>
		<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
			<div data-uk-height-match="target:.dk-box-content .box-text;">
				<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-medium" data-uk-grid data-uk-height-match=".dk-text-content">
					<% loop News %>
					
					<div class="box uk-transition-toggle uk-height-1-1" tabindex="0">
		   				<a href="$Link">
							<h3 class="uk-margin uk-text-truncate">$MenuTitle</h3>
							<% if $Image %>
						    	<div class="uk-flex uk-flex-center uk-flex-middle">
						    		<img class="dk-icon uk-width-auto" src="$Image.Fit(300,300).URL" />
						    	</div>
						    <% end_if %>
							<div class="uk-margin-top dk-box-content">
								<div class="dk-text-content uk-margin-small">$Lead.limitWordCount(20)</div>
						    	<div class="box-text"><%t News.WEITER 'weiterlesen' %><span data-uk-icon="icon:chevron-right;ratio:0.8"></span></div>
						    </div>
						</a>
					</div>
					
					<% end_loop %>
				</div>
			</div>
		</div>