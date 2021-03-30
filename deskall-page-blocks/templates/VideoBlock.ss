

<% if Layout == "carousel" %>
<div data-uk-slider>

	<div class="uk-position-relative">

		<div class="uk-slider-container">
			<ul class="uk-slider-items <% if isChildren %>uk-child-width-1-1 <% else %>$VideoPerLine<% end_if %> uk-grid" data-uk-height-match="li">
				$VideosHTML
				<% if activeVideos.exists %>
					<% loop activeVideos %>
						<li class="uk-height-large">
							<div class="uk-card uk-width-1-1">
								<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
									<video src="$File.URL" class="uk-width-1-1 data-uk-video="<% if Top.Autoplay %>autoplay: inview;<% end_if %>" <% if Top.Autoplay %>autoplay<% end_if %> loop playslinline width="480" height="360" controls <% if VideoPreview %>poster="$VideoPreview.FocusFill(480,360).URL"<% end_if %>>
										<source src="$File.URL" type="video/{$File.getExtension}">
									</video>
								</div>
								<% if Title || HTML %>
								<div class="uk-card-body">
									<% if Title %><h3 class="uk-card-title">$Title</h3><% end_if %> 
									<% if HTML %><div class="dk-text-content">$HTML</div><% end_if %>
								</div>
								<% end_if %>
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
</div>
<% else %>
	<div class="uk-flex-center $VideoPerLine uk-grid-small" data-uk-grid>
		$VideosHTML
		<% if activeVideos.exists %>
			<% loop activeVideos %>
				<li class="uk-height-large">
					<div class="uk-card uk-width-1-1">
						<div class="uk-card-media-left uk-flex uk-flex-center uk-flex-middle" data-uk-lightbox>
							<video class="uk-width-1-1 data-uk-video="<% if Autoplay %>autoplay: inview;<% end_if %>" loop playslinline width="480" height="360" controls <% if VideoPreview %>poster="$VideoPreview.FocusFill(480,360).URL"<% end_if %>>
								<source src="$File.URL" type="video/{$File.getExtension}">
							</video>
						</div>
						<% if Title || HTML %>
						<div class="uk-card-body">
							<% if Title %><h3 class="uk-card-title">$Title</h3><% end_if %> 
							<% if HTML %><div class="dk-text-content">$HTML</div><% end_if %>
						</div>
						<% end_if %>
					</div>
				</li>
			<% end_loop %>
		<% end_if %>
	</div>
	<% end_if %>
<% if HTML || LinkableLinkID > 0 %>
<% include TextBlock %>
<% end_if %>