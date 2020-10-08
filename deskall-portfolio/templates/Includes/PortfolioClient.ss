<div class="uk-modal-body">
	$Header
	<div class="uk-child-width-1-2@s" data-uk-grid>
	<div>
		$Title
	</div>
	<% if GalleryImages.exists %>
	<div data-uk-slider>
		<div class="uk-position-relative uk-visible-toggle">
			<div class="uk-slider-container">
				<ul class="uk-slider-items uk-child-width-1-2@s uk-grid-small" data-uk-grid>
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