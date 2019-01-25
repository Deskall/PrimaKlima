
		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>


		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>

		<% if Layout == "carousel" %>
		<div data-uk-slider>

		    <div class="uk-position-relative">

		        <div class="uk-slider-container">
		            <ul class="uk-slider-items <% if isChildren %>uk-child-width-1-1 <% else %>$VideoPerLine<% end_if %> uk-grid uk-grid-match" data-uk-height-match=".uk-card-body">
		            	<% loop ActiveVideos %>
		            	<li class="uk-height-1-1">
		            		<div class="uk-card uk-card-default uk-child-width-1-2" data-uk-grid>
                    			<div class="uk-card-media-left"><iframe src="$URL" frameborder="0" class="uk-width-1-1 uk-height-1-1" allowfullscreen  data-uk-video="automute: true;autoplay:false;"></iframe>
                    			</div>
                    			<div class="uk-card-body">
	                    			<% if Title %><h3 class="uk-card-title">$Title</h3><% end_if %> 
	                    			<% if HTML %><div class="dk-text-content">$HTML</div><% end_if %>
	                    		</div>
                    		</div>
                    	</li>
                    	<% end_loop %>
		            </ul>
		        </div>
		        <div class="uk-hidden@s">
		            <a class="uk-position-center-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		            <a class="uk-position-center-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
		        </div>

		        <div class="uk-visible@s">
		            <a class="uk-position-center-left-out uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		            <a class="uk-position-center-right-out uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
		        </div>
		    </div>

		    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		</div>
		<% else %>
		<div class="uk-flex-center $VideoPerLine uk-grid-small uk-height-large" data-uk-grid data-uk-lightbox>
		   <% loop ActiveVideos %>
			<iframe src="$Src" frameborder="0" allowfullscreen data-uk-responsive data-uk-video="automute: true;autoplay:false;"></iframe>
		   <% end_loop %>
		</div>
		<% end_if %>
