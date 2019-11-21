<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-visible@m">
				<% include ProductSidebar %>
			</div>
			<div class="uk-width-3-4@m">
				<div class="element">
					<h1>$Title</h1>
					<div class="uk-panel">
						<div class="uk-margin">
							<video id="video-{$Product.ID}" class="product-video" data-uk-video width="480" height="360" controls data-order="{$Order.ID}">
								<source src="$Product.ProductFile.URL" type="video/{$Product.ProductFile.getExtension}">
							</video>
						</div>

						<div id="certificat" class="uk-margin-top-large" <% if not Order.wasSeen %>hidden<% end_if %>>
							<h3><%t ShopCustomer.YourCertificate 'Ihr Zertifikat' %></h3>
							<% if missingData %>
								<p><%t ShopCustomer.RequiredForCertificate 'Die folgenden Informationen sind erforderlich, um Ihr Zertifikat zu generieren' %></p>
								$CertificateForm
							<% else %>
							<a href="$Order.generateCertificatLink" target="_blank" class="uk-button uk-button-secondary uk-button-large" title="<%t ShopCustomer.DownloadCertificate 'Jetzt Ihr Zertifikat herunterladen' %>"><i class="fa fa-download uk-margin-small-right"></i><%t ShopCustomer.DownloadCertificate 'Jetzt Ihr Zertifikat herunterladen' %></a>
							<% end_if %>
						</div>
					</div>
				</div>
				<% with Product %>
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