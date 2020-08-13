<% if TextPosition == "before" %>
<div class="uk-margin-bottom dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<% end_if %>
<% if ItemType == "boxes" %>
	<% if Layout == "carousel" %>
		<div data-uk-slider="<% if not infiniteLoop %>finite:true;<% end_if %><% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %>">
			<div class="uk-position-relative uk-visible-toggle">
				<div class="uk-slider-container">
					<ul class="uk-slider-items $PicturesPerLine" data-uk-height-match=".uk-card-body" data-uk-grid>
						<% loop activeBoxes %>
						<li>
							<div class="uk-card uk-card-default uk-margin-bottom">
								<% if Image.exists %>
								<div class="uk-card-media-top">
									<img data-src="<% if $Image.getExtension == "svg" %>$Image.URL<% else %>
									<% if Up.RoundedImage %>
									$Image.FocusFill($Up.PictureWidth,$Up.PictureWidth).URL
									<% else_if Up.PaddedImages %>
									$Image.FitMax($Up.PictureWidth,$Up.PictureHeight).URL
									<% else %>
									$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL
									<% end_if %>
									<% end_if %>
									" alt="$Up.AltTag($Image.Description,$Title,$Up.Title)" title="$Up.TitleTag($Title,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
								</div>
								<% end_if %>
								<div class="uk-card-body uk-padding-small">
									<div class="uk-card-title">$Title</div>
									<p>$Content</p>
									<% if LinkableLinkID > 0 %>
									<% include CallToActionLink c=r,pos=center %>
									<% end_if %>
								</div>
							</div>
						</li>
						<% end_loop %>
					</ul>
				</div>
				<% if ShowNav %>
				<div class="uk-hidden@l uk-light">
					<a class="uk-position-center-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
					<a class="uk-position-center-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
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
	<% else_if Layout == "grid" %>
		<div class="uk-flex-center $PicturesPerLine uk-grid-small" data-uk-height-match="target:.uk-card-body;row:true;" data-uk-grid>
			<% loop activeBoxes %>
			<div>
				<div class="uk-card uk-card-default uk-margin-bottom">
					<% if Image.exists %>
					<div class="uk-card-media-top">
						<img data-src="<% if $Image.getExtension == "svg" %>$Image.URL<% else %>
						<% if Up.RoundedImage %>
							$Image.FocusFill($Up.PictureWidth,$Up.PictureWidth).URL
						<% else_if Up.PaddedImages %>
						$Image.FitMax($Up.PictureWidth,$Up.PictureHeight).URL
						<% else %>
						$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL
						<% end_if %>
						<% end_if %>
						" alt="$Up.AltTag($Image.Description,$Title,$Up.Title)" title="$Up.TitleTag($Title,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
					</div>
					<% end_if %>
					<div class="uk-card-body uk-padding-small">
						<div class="uk-card-title">$Title</div>
						<p>$Content</p>
						<% if LinkableLinkID > 0 %>
						<% include CallToActionLink c=r,pos=center %>
						<% end_if %>
					</div>
				</div>
			</div>
			<% end_loop %>

		</div>
	<% end_if %>
<% else_if ItemType == "logos" %>
	<div data-uk-slider="<% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %><% if not infiniteLoop %>finite:true;<% end_if %>">
		<div class="uk-position-relative">
			<div class="uk-slider-container uk-light">
				<ul class="uk-slider-items $PicturesPerLine" data-uk-grid >
					<% loop OrderedImages %>
					<li class="uk-flex uk-flex-middle uk-flex-center">
						<img data-src="
						<% if $getExtension == "svg" %> $URL <% else %> <% if Up.RoundedImage %>$Image.FocusFill($Up.PictureWidth,$Up.PictureWidth).URL<% else_if Up.PaddedImages %> $FitMax($Up.PictureWidth,$Up.PictureHeight).URL<% else %>$FocusFill($Up.PictureWidth,$Up.PictureHeight).URL<% end_if %><% end_if %>" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="<% if $getExtension == "svg" %>uk-slide-logo-svg<% else %>uk-slide-logo<% end_if %>  $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img> </li>
					<% end_loop %>
				</ul>
			</div>
			<% if ShowNav %>
				<div class="uk-hidden@l uk-light">
					<a class="uk-position-center-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
					<a class="uk-position-center-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
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
	<% if Layout == "carousel" %>
	<div data-uk-slider="<% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %><% if not infiniteLoop %>finite:true;<% end_if %>">
		<div class="uk-position-relative">
			<div class="uk-slider-container uk-light">
				<% if lightboxOff %>
				<ul class="uk-slider-items $PicturesPerLine" data-uk-grid >

					<% loop OrderedImages %>
					<li class="uk-flex uk-flex-middle uk-flex-center">
						<img data-src="
						<% if $getExtension == "svg" %>
						$URL
						<% else %>
						<% if Up.RoundedImage %>
							$FocusFill($Up.PictureWidth,$Up.PictureWidth).URL
						<% else_if Up.PaddedImages %>
						$FitMax($Up.PictureWidth,$Up.PictureHeight).URL
						<% else %>
						$FocusFill($Up.PictureWidth,$Up.PictureHeight).URL
						<% end_if %>
						<% end_if %>" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
					</li>
					<% end_loop %>
				</ul>
				<% else %>
				<ul class="uk-slider-items $PicturesPerLine" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;">
					<% loop OrderedImages %>
					<li class="uk-flex uk-flex-middle uk-flex-center">
						<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
							<img data-src="
							<% if $getExtension == "svg" %>
							$URL
							<% else %>
							<% if Up.RoundedImage %>
								$FocusFill($Up.PictureWidth,$Up.PictureWidth).URL
							<% else_if Up.PaddedImages %>
							$FitMax($Up.PictureWidth,$Up.PictureHeight).URL
							<% else %>
							$FocusFill($Up.PictureWidth,$Up.PictureHeight).URL
							<% end_if %>
							<% end_if %>" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
						</a>
					</li>
					<% end_loop %>
				</ul>
				<% end_if %>
			</div>
			<% if ShowNav %>
				<div class="uk-hidden@l uk-light">
					<a class="uk-position-center-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
					<a class="uk-position-center-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
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
		<% if lightboxOff %>
		<div class="uk-flex-center $PicturesPerLine uk-grid-small" data-uk-grid >
			<% if PaddedImages %>
			<% loop OrderedImages %>
			<div class="uk-flex uk-flex-middle uk-flex-center">
				<img data-src="<% if $getExtension == "svg" %>$URL<% else %>
				$FitMax($Up.PictureWidth,$Up.PictureHeight).URL
				<% end_if %>
				" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
			</div>
			<% end_loop %>
			<% else %>
			<% loop OrderedImages %>
			<div class="uk-flex uk-flex-middle uk-flex-center">
				<img data-src="<% if $getExtension == "svg" %>$URL<% else_if Up.RoundedImage %>$FocusFill($Up.PictureWidth,$Up.PictureWidth).URL<% else %> $FocusFill($Up.PictureWidth,$Up.PictureHeight).URL <% end_if %>
				" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
			</div>
			<% end_loop %>
			<% end_if %>
		</div>
		<% else %>
		<div class="uk-flex-center $PicturesPerLine uk-grid-small" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;">
			<% if PaddedImages %>
				<% loop OrderedImages %>
				<div class="uk-flex uk-flex-middle uk-flex-center">
					<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description"><img data-src="<% if $getExtension == "svg" %>$URL<% else_if Up.RoundedImage %>$FocusFill($Up.PictureWidth,$Up.PictureWidth).URL<% else %>
						$FitMax($Up.PictureWidth,$Up.PictureHeight).URL
						<% end_if %>
						" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
					</a>
				</div>
				<% end_loop %>
			<% else %>
				<% loop OrderedImages %>
				<div class="uk-flex uk-flex-middle uk-flex-center">
					<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description"><img data-src="<% if $getExtension == "svg" %>$URL<% else_if Up.RoundedImage %>$FocusFill($Up.PictureWidth,$Up.PictureWidth).URL<% else %>
						$FocusFill($Up.PictureWidth,$Up.PictureHeight).URL
						<% end_if %>
						" alt="$Up.AltTag($Description,$Name,$Up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1 $Top.ImagePadding <% if $Top.RoundedImage %>uk-border-circle<% end_if %>" data-uk-img>
					</a>
				</div>
				<% end_loop %>
			<% end_if %>
		</div>
		<% end_if %>
	<% end_if %>
<% end_if %>

<% if TextPosition == "after" %>
<div class="uk-margin-top dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<% end_if %>