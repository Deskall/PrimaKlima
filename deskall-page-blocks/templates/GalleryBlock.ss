
<% if TextPosition == "before" %>
	<% if HTML || LinkableLinkID > 0 %>
		<% include TextBlock %>
	<% end_if %>
<% end_if %>

	<% if Layout == "carousel" %>
	<div data-uk-slider="<% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %><% if not infiniteLoop %>finite:true;<% end_if %>">
		<div class="uk-position-relative">
			<div class="uk-slider-container uk-light">
				<ul class="uk-slider-items $PicturesPerLine" data-uk-grid <% if not lightboxOff %>data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
					<% loop OrderedImages %>
					<li class="uk-flex uk-flex-middle uk-flex-center">
						<% if not lightboxOff %><a href="$getSourceURL" class="dk-lightbox" data-caption="$Description"><% end_if %>
							<% include GalleryImage Alt=$Up.AltTag($Description,$Name,$Up.Title),PaddedImage=$Up.PaddedImage,Height=$Up.PictureHeight,Width=$Up.PictureWidth %>
						<% if not lightboxOff %></a><% end_if %>
					</li>
					<% end_loop %>
				</ul>
			</div>
			<% if ShowNav %>
				<div class="uk-hidden@l uk-light">
					<a class="uk-position-bottom-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
					<a class="uk-position-bottom-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
				</div>

				<div class="uk-visible@l">
					<a class="uk-position-center-left-out uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
					<a class="uk-position-center-right-out uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
				</div>
			<% end_if %>
		</div>
		<% if ShowDot %>
			<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		<% end_if %>
	</div>
	<% else %>
		<div class="uk-flex-center $PicturesPerLine uk-grid-small" data-uk-grid <% if not lightboxOff %>data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
			<% loop OrderedImages %>
			<div class="uk-flex uk-flex-middle uk-flex-center">
				<% if not lightboxOff %><a href="$getSourceURL" class="dk-lightbox" data-caption="$Description"><% end_if %>
					<% include GalleryImage Alt=$Up.AltTag($Description,$Name,$Up.Title),PaddedImage=$Up.PaddedImage,Height=$Up.PictureHeight,Width=$Up.PictureWidth %>
				<% if not lightboxOff %></a><% end_if %>
			</div>
			<% end_loop %>
		</div>
	<% end_if %>

<% if TextPosition == "after" %>
	<% if HTML || LinkableLinkID > 0 %>
	<% include TextBlock %>
	<% end_if %>
<% end_if %>