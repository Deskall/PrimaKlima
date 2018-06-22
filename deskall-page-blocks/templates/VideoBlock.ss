
		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>


		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>

		<% if Layout == "carousel" %>
		<div data-uk-slider>

		    <div class="uk-position-relative">

		        <div class="uk-slider-container uk-light">
		            <ul class="uk-slider-items uk-height-large <% if isChildren %>uk-child-width-1-1 <% else %>$VideoPerLine<% end_if %> uk-grid uk-grid-match" data-uk-lightbox>
		            	$GetVideos
		            </ul>
		        </div>
		        <% if not isChildren %>
		        <div class="uk-hidden@s uk-light">
		            <a class="uk-position-center-left uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		            <a class="uk-position-center-right uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
		        </div>

		        <div class="uk-visible@s">
		            <a class="uk-position-center-left-out uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		            <a class="uk-position-center-right-out uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
		        </div>
		        <% end_if %>
		    </div>

		    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		</div>
		<% else %>
		<div class="uk-flex-center $VideoPerLine uk-grid-small" data-uk-grid data-uk-lightbox>
		    $GetVideos
		</div>
		<% end_if %>
