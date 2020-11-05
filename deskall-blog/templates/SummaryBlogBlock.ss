<div class="dk-text-content uk-text-muted $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<div class="uk-margin">
	
		<div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid >
			<% loop getPosts %>
				<div>
			        <a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "mehr über '{title}' lesen..." title=$Title %>">
								<div class="uk-card uk-card-default uk-card-hover uk-border-rounded uk-grid-collapse uk-margin" data-uk-grid>
									<% if FeaturedImage %>
									<div class="uk-width-1-1 uk-width-1-3@m">
							            <div class="uk-card-media-left uk-cover-container">
							                <img src="$FeaturedImage.ScaleWidth(390).URL" alt="$FeaturedImage.AltTag($Title)" data-uk-cover>
							                <canvas with="390" height="300"></canvas> 
							            </div>
							        </div>
							        <div class="uk-width-1-1 uk-width-2-3@m">
							        <% else %>
							        <div class="uk-width-1-1">
						            <% end_if %>

							            <div class="uk-card-body uk-padding-small">
							                <strong class="uk-card-title">$Title</strong>
							                <div>
							                	<% if $Summary %>
							                		$Summary.LimitWordCount(30)
							                	<% else %>
							                		$SummaryFromBlocks.LimitWordCount(30)
							                	<% end_if %>
											</div>
							                <div class="uk-position-bottom-right uk-position-medium"><%t SilverStripe\\Blog\\Model\\Blog.ReadPost "Lesen" %><i class="icon icon-chevron-right uk-margin-small-left"></i></div>
							            </div>
							        </div>
						        </div>
					</a>
			    </div>
			<% end_loop %>
		</div>
	
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>