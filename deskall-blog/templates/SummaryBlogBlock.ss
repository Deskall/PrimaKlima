<div class="dk-text-content uk-text-muted $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
	<div data-uk-height-match="target:.uk-card-body;row:false;">
		<div class="uk-child-width-1-2@s uk-child-width-1-3@l uk-grid-match uk-grid-medium" data-uk-grid >
			<% loop LastPosts %>
				<div>
			        <a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "mehr über '{title}' lesen..." title=$Title %>">
								<div class="uk-card uk-card-default uk-card-hover uk-border-rounded uk-grid-collapse uk-child-width-1-1 uk-margin" data-uk-grid>
						            <div class="uk-card-media-left uk-cover-container">
						                <img src="$FeaturedImage.ScaleWidth(390).URL" alt="$FeaturedImage.AltTag($Title)" data-uk-cover>
						                <canvas with="390" height="300"></canvas> 
						            </div>
						            <div class="uk-card-body uk-padding-small">
						                <h3 class="uk-card-title">$Title</h3>
						                <div>
						                	<% if $Summary %>
						                		$Summary.LimitWordCount(30)
						                	<% else %>
						                		$SummaryFromBlocks.LimitWordCount(30)
						                	<% end_if %>
										</div>
						                <div class="uk-position-bottom-right uk-position-medium"><%t SilverStripe\\Blog\\Model\\Blog.ReadPost "Lesen" %><i class="fa fa-chevron-right uk-margin-small-left"></i></div>
						            </div>
						        </div>
						    	</a>
			    </div>
			<% end_loop %>
		</div>
	</div>
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>