<% if $VideoList %>
	<div class="video-block">
		<% if $Content %>
		<div class="video-block-text">
			$Content
		</div>
		<% end_if %>

		<% if $countVideos < 2 %>
			$GetVideos
		<% else %>
			<div class="video-block-gallery">
				<div class="owl-gallery owl-carousel owl-theme owl-gallery-videos">
					$GetVideos
				</div>
			</div>
		<% end_if %>

	</div>
<% end_if %>





