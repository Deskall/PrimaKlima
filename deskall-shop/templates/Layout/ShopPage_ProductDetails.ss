<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-visible@m">
				<% include ProductSidebar %>
			</div>
			<div class="uk-width-3-4@m">
				<div class="uk-margin">
					<a href="$MainShopPage.Link" title="$MainShopPage.Title">$MainShopPage.MenuTitle</a> » <a href="$Product.Category.Link" title="$Product.Category.Title">$Product.Category.Title</a> » <span class="uk-text-muted">$Product.MenuTitle</span>
				</div>
				<% with Product %>
				<div class="element" id="product-{$ID}">
					<h1>$Title</h1>
					<div class="uk-panel">
						<div class="<% if MainImage.exists || Images.exists %>uk-child-width-1-2@s<% else %>uk-child-width-1-1<% end_if %> uk-grid-small" data-uk-grid>
							<% if MainImage.exists || Images.exists %>
							<div>
								<div class="uk-position-relative" tabindex="-1" data-uk-slideshow="min-height: 350; max-height: 350; animation: fade">

								<ul class="uk-slideshow-items" data-uk-lightbox>
									<% if MainImage.exists %>
									<% with MainImage %>
									<li class="uk-flex uk-flex-middle uk-flex-center">
										<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
											<img data-src="
											<% if $getExtension == "svg" %>
											$URL
											<% else %>
											$Fit(350,350).URL
											<% end_if %>" alt="$Up.AltTag($Description,$Name,$up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img>
										</a>
									</li>
									<% end_with %>
									<% end_if %>
									<% if Images.exists %>
									<% loop Images.sort('SortOrder') %>
									<li class="uk-flex uk-flex-middle uk-flex-center">
										<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
											<img data-src="
											<% if $getExtension == "svg" %>
											$URL
											<% else %>
											$Fit(350,350).URL
											<% end_if %>" alt="$Up.AltTag($Description,$Name,$up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img>
										</a>
									</li>
									<% end_loop %>
									<% end_if %>
									
								</ul>

									<a class="uk-position-center-left uk-position-small uk-dark uk-text-primary" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
									<a class="uk-position-center-right uk-position-small uk-dark uk-text-primary" data-uk-slidenav-next data-uk-slideshow-item="next"></a>

							</div>
							</div>
							<% end_if %>
							<div>
								<% if $currentPrice != $Price %><div><s>$Price EUR</s></div><div class="uk-text-lead uk-text-primary">$DiscountPrice EUR<% if DiscountUntil %> <%t Product.DiscountExpire 'läuft {date} aus' date=$DiscountUntil.Ago %><% end_if %></div><% else %><div class="uk-text-lead uk-text-primary">$Price EUR</div><% end_if %>
								<% if not Online %><div class="uk-margin-small">
									<div class="uk-background-muted uk-padding-small uk-flex uk-flex-middle"><% if InStock %><div class="uk-label uk-label-success uk-margin-medium-right">im Stock</div><% end_if %><% if DeliveryTime %><i class="fa fa-truck uk-margin-small-right"></i><%t Product.DeliveryTime 'Lieferzeit:' %> $DeliveryTime<% end_if %></div>
								</div><% end_if %>
								<div class="uk-margin-small">
								<%-- 	<div class="uk-inline">
									    <a class="uk-form-icon uk-form-icon uk-text-muted" data-uk-icon="icon: minus;ratio:0.5" data-less disabled="disabled"></a>
									    <a class="uk-form-icon uk-form-icon-flip uk-text-muted" data-uk-icon="icon: plus;ratio:0.5" data-plus></a>
										<input type="number" min="1" <% if Quantities %>max="$Quantities"<% end_if %> class="uk-input uk-width-small uk-text-center" required value="1" />
									</div> --%>
									<a class="uk-button uk-button-primary" href="$BuyLink" title="<%t Product.BUYNOW 'Jetzt kaufen' %>"><i class="fa fa-shopping-cart uk-margin-right"></i><%t Product.BUYNOW 'Jetzt kaufen' %></a>
								</div>
								<% if Subtitle %><h2 class="uk-text-muted">$Subtitle</h2><% end_if %>
								<div class="uk-text-lead uk-text-muted">$LeadText</div>
							</div>
						</div>
						
						
						
						<div class="uk-margin">
							<h3><%t Product.Content 'Produkt Beschreibung:' %></h3>
							$Content
						</div>
					
						<% if Files.exists %>
						<div class="uk-margin">
							<h3><%t Event.Files 'Downloads:' %></h3>
							<% loop Files %>
							<div class="uk-flex uk-flex-middle">
								<img src="$ThumbnailURL(120,120)" />
								<div>
									<strong>$Title</strong>
									<div>$Extension - $Size</div>
									<a href="$URL" target="_blank" data-uk-tooltip="title: Herunterladen"><i class="fa fa-download uk-margin-small-right" ></i><span class="file-name">$Name.LimitCharacters(30)</span></a>
								</div>
							</div>
							<% end_loop %>
						</div>
						<% end_if %>
						<div class="uk-margin">
							$Footer
						</div>
					</div>
				</div>
				<% if CloseProducts %>
				<h4><%t Product.CloseProducts 'Das könnte Sie auch interessieren' %></h4>
					<div data-uk-slider>

					    <div class="uk-position-relative uk-visible-toggle uk-dark" tabindex="-1">

					        <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">
					            <% loop CloseProducts %>
					            <li>
					                <% include ProductCard %>
					            </li>
					            <% end_loop %>
					        </ul>

					        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
					        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

					    </div>

					    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

					</div>
				<% end_if %>

				<% end_with %>

			</div>
		</div>
	</div>
</section>