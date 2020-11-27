
<% if TextPosition == "before" %>
	<% include TextBlock %>
<% end_if %>

<div data-uk-slider="<% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %><% if not infiniteLoop %>finite:true;<% end_if %>">
		<div class="uk-position-relative">
			<div class="uk-slider-container">
				<ul class="uk-slider-items $PicturesPerLine" data-uk-grid >
					<% loop activeLogos %>
					<li class="uk-flex uk-flex-middle uk-flex-center">
						<% if LinkableLinkID > 0 %>
						<% with LinkableLink %>
						<a href="$LinkURL" {$TargetAttr} <% if Rel %>rel="$Rel"<% end_if %>>
						<% end_with %>
						<% end_if %>
						<figure>
							<img data-src="<% if $Image.getExtension == "svg" %>$Image.URL<% else %>$Image.FitMax($Up.PictureWidth,$Up.PictureHeight).URL<% end_if %>" alt="Logo $Title" class="<% if $Image.getExtension == "svg" %>uk-slide-logo-svg<% else %>uk-slide-logo<% end_if %> $Top.ImagePadding" data-uk-img>
							<% if Title %><figcaption class="uk-text-center uk-margin-small-top">$Title</figcaption><% end_if %>
						</figure>
						<% if LinkableLinkID > 0 %></a><% end_if %>
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

<% if TextPosition == "after" %>
	<% include TextBlock %>
<% end_if %>