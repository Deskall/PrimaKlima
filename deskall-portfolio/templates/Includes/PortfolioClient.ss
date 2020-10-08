<div class="uk-modal-body uk-padding-remove">
	$Header
	<div class="uk-padding-small">
		<div>
			<% if Website %>
			<div class="website"><a href="$Website" class="uk-flex uk-flex-middle" target="_blank" rel="nofollow"><span data-uk-icon="world" class="uk-margin-small-right"></span><span>Website</span></a></div>
			<% end_if %>
			<div class="title">$Title</div>
			<% if Description %>
			<div class="dk-text-content">$Description</div>
			<% end_if %>
			
		</div>
		<% if GalleryImages.exists %>
		<div class="uk-padding" data-uk-slider>
			<div class="uk-position-relative uk-visible-toggle">
				<div class="uk-slider-container">
					<ul class="uk-slider-items uk-child-width-1-1 uk-grid-small" data-uk-grid>
						<% loop GalleryImages %>
						<li>
							$Me
						</li>
						<% end_loop %>
					</ul>
				</div>
			</div>
			<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		</div>
		<% end_if %>
	</div>
</div>	