
		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>

	
		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>

		<% if Layout == "carousel" %>
		<div data-uk-slider="<% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %>">

		    <div class="uk-position-relative">

		        <div class="uk-slider-container uk-light">
		            <ul class="uk-slider-items $PicturesPerLine" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;">
		            	<% loop OrderedImages %>
		                <li class="uk-flex uk-flex-middle uk-flex-center">
				            <a href="$getSourceURL" class="dk-lightbox" data-caption="$Description"><img data-src="<% if $getExtension == "svg" %>$URL<% else %>$FocusFill($Up.PictureWidth,$Up.PictureHeight).URL<% end_if %>" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img></a>
				        </li>
				     	<% end_loop %>
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
		<div class="uk-flex-center <% if isChildren %>uk-child-width-1-1 <% else %>$PicturesPerLine<% end_if %> uk-grid-small" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;">
		    <% loop OrderedImages %>
		    	<div class="uk-flex uk-flex-middle uk-flex-center">
					 <a href="$getSourceURL" class="dk-lightbox" data-caption="$Description"><img data-src="<% if $getExtension == "svg" %>$URL<% else %>$FocusFill($Up.PictureWidth,$Up.PictureHeight).URL<% end_if %>" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img></a>
				</div>
			<% end_loop %>
		</div>
		<% end_if %>
