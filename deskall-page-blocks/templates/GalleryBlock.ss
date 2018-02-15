
		<h2>$Title</h2>
		$HTML

		<% if Layout == "carousel" %>
		<div uk-slider>

		    <div class="uk-position-relative">

		        <div class="uk-slider-container uk-light">
		            <ul class="uk-slider-items uk-child-width-1-3@s uk-child-width-1-4@ uk-grid" uk-lightbox>
		            	<% loop OrderedImages %>
		                <li>
				            <a href="$URL"><img src="$FocusFill(350,250).URL" alt=""></a>
				        </li>
				     	<% end_loop %>
		            </ul>
		        </div>

		        <div class="uk-hidden@s uk-light">
		            <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
		            <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
		        </div>

		        <div class="uk-visible@s">
		            <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
		            <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
		        </div>

		    </div>

		    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		</div>
		<% else %>
		<div class="uk-flex-center uk-child-width-1-2@s uk-child-width-1-3@m  uk-child-width-1-4@l uk-grid-small" uk-grid uk-lightbox>
		    <% loop OrderedImages %>
		    	<div>
					<a href="$URL"><img src="$FocusFill(350,250).URL" alt=""></a>
				</div>
			<% end_loop %>
		</div>
		<% end_if %>
