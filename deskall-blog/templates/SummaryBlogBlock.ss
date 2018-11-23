<div class="dk-text-content uk-text-muted $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
	<div data-uk-height-match="target:.uk-card-body;row:false;">
		<div class="uk-child-width-1-2@s uk-child-width-1-3@l uk-grid-match uk-grid-medium" data-uk-grid >
			<% loop LastPosts %>
				<div>
			        <div class="uk-card uk-card-hover blogpost">
			            <div class="uk-card-media-top">
			            	<% if FeaturedImage %>
			            	<div class="uk-cover-container uk-height-medium">
			                	<img src="$FeaturedImage.ScaleWidth(350).URL" alt="$FeaturedImage.AtlTag($Title)" data-uk-cover/>
			            	<div class="uk-position-bottom uk-light">
			            		<div class="uk-padding-small uk-text-break"><h3 class="uk-card-title">$Title</h3></div>
			            	</div>
			            </div>
			            	
			                <% end_if %>
			            </div>
			            <div class="uk-card-body uk-card-default uk-padding-small uk-text-justify">
			                <% if Summary %>
			                $Summary
			                <% else %>
			                <p>$Excerpt</p>
			                <% end_if %>
			            </div>
			            <div class="uk-card-footer uk-card-default uk-padding-small">
			            	<a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"><%t SilverStripe\\Blog\\Model\\Blog.ReadPost "Lire l'article" %> <i class="icon icon-arrow-right-b"></i></a>
			            </div>
			        </div>
			    </div>
			<% end_loop %>
		</div>
	</div>
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>