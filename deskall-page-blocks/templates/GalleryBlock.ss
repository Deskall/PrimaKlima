
		$HTML

		<% if $CallToActionLink.Page.Link %>
			<% include CallToActionLink c=w,b=secondary,pos=right %>
		<% end_if %>

		<% if Layout == "carousel" %>
		<div data-uk-slider>

		    <div class="uk-position-relative">

		        <div class="uk-slider-container uk-light">
		            <ul class="uk-slider-items uk-child-width-1-3@s uk-child-width-1-4@ uk-grid" data-uk-lightbox>
		            	<% loop OrderedImages %>
		                <li>
				            <a href="$URL"><img src="$FocusFill(350,250).URL" alt="" class="uk-width-1-1"></a>
				        </li>
				     	<% end_loop %>
		            </ul>
		        </div>

		        <div class="uk-hidden@s uk-light">
		            <a class="uk-position-center-left uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		            <a class="uk-position-center-right uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
		        </div>

		        <div class="uk-visible@s">
		            <a class="uk-position-center-left-out uk-position-small" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		            <a class="uk-position-center-right-out uk-position-small" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>
		        </div>

		    </div>

		    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		</div>
		<% else %>
		<div class="uk-flex-center uk-child-width-1-2@s uk-child-width-1-3@m  uk-child-width-1-4@l uk-grid-small" data-uk-grid data-uk-lightbox>
		    <% loop OrderedImages %>
		    	<div>
					<a href="$URL"><img src="$FocusFill(350,250).URL" alt="" class="uk-width-1-1"></a>
				</div>
			<% end_loop %>
		</div>
		<% end_if %>
