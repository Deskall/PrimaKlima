<% if HTML %>
<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<% end_if %>

<% if LinkableLinkID > 0 %>
<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>

<% if Layout == "carousel" %>
<div data-uk-slider>

	<div class="uk-position-relative">

		<div class="uk-slider-container">
			<ul class="uk-slider-items <% if isChildren %>uk-child-width-1-1 <% else %>$VideoPerLine<% end_if %> uk-grid" data-uk-height-match="li">
				$VideosHTML
				<% if activeVideos.exists %>
					<% loop activeVideos %>
						<li class="uk-height-1-1">
							<div class="uk-card uk-card-default uk-child-width-auto" data-uk-grid>
								<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
									<video data-uk-video="autoplay: false;" width="480" height="360" controls <% if VideoPreview %>poster="$VideoPreview.FocusFill(480,360).URL"<% end_if %>>
										<source src="$File.URL" type="video/{$File.getExtension}">
									</video>
								</div>
								<div class="uk-card-body">
									<% if Title %><h3 class="uk-card-title">$Title</h3><% end_if %> 
									<% if HTML %><div class="dk-text-content">$HTML</div><% end_if %>
								</div>
							</div>
						</li>
					<% end_loop %>
				<% end_if %>
			</ul>
		
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
	<div class="uk-flex-center $VideoPerLine uk-grid-small uk-height-large" data-uk-grid>
		$VideosHTML
		<% if activeVideos.exists %>
			<% loop activeVideos %>
				<li class="uk-height-1-1">
					<div class="uk-card uk-card-default uk-child-width-auto" data-uk-grid>
						<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
							<video data-uk-video="autoplay: false;" width="480" height="360" controls <% if VideoPreview %>poster="$VideoPreview.FocusFill(480,360).URL"<% end_if %>>
								<source src="$File.URL" type="video/{$File.getExtension}">
							</video>
						</div>
						<div class="uk-card-body">
							<% if Title %><h3 class="uk-card-title">$Title</h3><% end_if %> 
							<% if HTML %><div class="dk-text-content">$HTML</div><% end_if %>
						</div>
					</div>
				</li>
			<% end_loop %>
		<% end_if %>
	</div>
	<% end_if %>
