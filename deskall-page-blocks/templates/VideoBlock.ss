
<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	<% if CollapseText %>
			<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
			<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
		<% else %>
			$HTML
		<% end_if %>
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
					<div class="uk-card uk-card-default uk-child-width-auto" data-uk-grid>
						<% if Type == "Datei" %>
						<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
							<video data-uk-video="autoplay: false;" width="480" height="360" controls <% if VideoPreview %>poster="$VideoPreview.FocusFill(480,360).URL"<% end_if %>>
								<source src="$File.URL" type="video/{$File.getExtension}">
								</video>
							</div>
							<% else %>
							<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
								<a class="uk-inline uk-panel uk-link-muted uk-text-center uk-width-1-1" href="$URL" caption="$Title">
									<figure>
										<img src="$ThumbnailURL" width="400" alt="" class="uk-width-1-1">
										<div class="uk-position-center">
										    <div class="dk-video-play"><span class="fa fa-play-circle"></span></div>
										</div>
									</figure>
								</a>
							</div>
							<% end_if %>
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
		<div class="uk-card uk-card-default uk-child-width-auto" data-uk-grid>
			<% if Type == "Datei" %>
			<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
				<video data-uk-video="autoplay: false;" width="480" height="360" controls <% if VideoPreview %>poster="$VideoPreview.FocusFill(480,360).URL"<% end_if %>>
					<source src="$File.URL" type="video/{$File.getExtension}">
					</video>
				</div>
				<% else %>
				<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
					<a class="uk-inline uk-panel uk-link-muted uk-text-center uk-width-1-1" href="$URL" caption="$Title">
						<figure>
							<img src="$ThumbnailURL" width="400" alt="" class="uk-width-1-1">
							<div class="uk-position-center">
							    <div class="dk-video-play"><span class="fa fa-play-circle"></span></div>
							</div>
						</figure>
					</a>
				</div>
				<% end_if %>
				<div class="uk-card-body">
					<% if Title %><h3 class="uk-card-title">$Title</h3><% end_if %> 
					<% if HTML %><div class="dk-text-content">$HTML</div><% end_if %>
				</div>
			</div>
			<% end_loop %>
		</div>
		<% end_if %>
