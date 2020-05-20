
<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>


<% if LinkableLinkID > 0 %>
<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>

<% if Layout == "carousel" %>
<div data-uk-slider>

	<div class="uk-position-relative">

		<div class="uk-slider-container">
			<ul class="uk-slider-items <% if isChildren %>uk-child-width-1-1 <% else %>$VideoPerLine<% end_if %> uk-grid">
				$VideosHTML
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
	</div>
	<% end_if %>
