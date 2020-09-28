	<div id="mobile-cart-container" class="uk-hidden@m" <% if not $activeCart %>hidden="hidden"<% end_if %> data-uk-sticky>
		<div class="cart-container">
			<div class="uk-card uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header toggle-cart uk-padding-remove-horizontal" data-target="#mobile-order-preview">
					<div class="uk-position-relative">
						<strong class="uk-card-title uk-padding-small"><%t Configurator.CartLabel 'Warenkorb' %> - <span class="total-monthly-price">$activeCart.PrintMonthlyPrice</span></strong>
						<div class="uk-position-absolute uk-position-center-right">
							<button type="button" class="cart-button show"><span data-uk-icon="icon:chevron-down;ratio:1.5"></span></button>
							<button type="button" class="cart-button uk-hidden hide"><span data-uk-icon="icon:chevron-up;ratio:1.5"></span></button>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	<div id="mobile-order-preview" hidden>
		<div class="uk-card-body WhiteBackground order-preview">
			<div data-uk-spinner></div>
		</div>
		<div class="uk-card-footer BlackBackground">
			<a href="$ShopPage.Link" class="uk-button uk-button-primary uk-display-block"><%t Configurator.Order 'Bestellen' %></a>
		</div>
	</div>
	<section class="uk-section uk-section-medium" style="background-color:#eee;">
		<div class="uk-container uk-container-medium">
			<h1>$Title</h1>
			<%-- <h2>$SiteConfig.ConfiguratorTitle</h2> --%>
			<% if not activePLZ %>

			<% if $chosenItem %>
			<strong>Ihre Auswahl: $chosenItem.Title</strong>
			<% end_if %>

			$SiteConfig.PLZModalBody
			<form method="POST" action="{$Link}plz-speichern" class="form-std plz-form">
				<div class="uk-flex uk-flex-left uk-flex-top">
				   <div>
				        <input class="uk-input uk-text-center" type="text" name="plz-choice" required="required" placeholder="Ihrer PLZ">
				   </div>
				   <button class="uk-button uk-button-primary" type="submit">Region prüfen</button>
				</div>
			</form>
			<% else %>
				<% if activePLZ.AlternateOffer %>
				<div class="connection-type">
		          <h3><%t Order.ExistingTVConnection 'Ihre Anschluss-Art' %></h3>
		          <div class="uk-child-width-1-3" data-uk-grid>
		          	<div class="uk-text-center"><a><img class="uk-display-block uk-margin-small-bottom" src="$ThemeDir/img/bestellung-glasfaserdose.svg" data-value="GlasfaserDose" data-type="Fiber" alt="<%t Order.FiberTV 'Glasfaser-Dose' %>" title="<%t Order.FiberTV 'Glasfaser-Dose' %>"/><span><%t Order.FiberTV 'Glasfaser-Dose' %><a data-uk-toggle="target: #Glasfaser-Dose-modal" class="uk-margin-small-left"><span data-uk-icon="info" class="uk-margin-small-right"></span></a></span></a></div>
		            <div class="uk-text-center"><a><img class="uk-display-block uk-margin-small-bottom" src="$ThemeDir/img/bestellung-dose-f75.svg" data-value="Kabelnetz" data-type="Cable" alt="<%t Order.CableTV 'Kabel-TV-Dose' %>" title="<%t Order.CableTV 'Kabel-TV-Dose' %>"/><span><%t Order.CableTV 'Kabel-TV-Dose' %><a data-uk-toggle="target: #Kabel-TV-Dose-modal" class="uk-margin-small-left"><span data-uk-icon="info" class="uk-margin-small-right"></span></a></span></a></div>
		            <div class="uk-text-center"><a><img class="uk-display-block uk-margin-small-bottom" src="$ThemeDir/img/bestellung-dose-unknown.svg" data-value="Dose noch nicht bekannt" data-type="unknown" alt="<%t Order.UnknownTV 'Dose noch nicht bekannt' %>" title="<%t Order.UnknownTV 'Dose noch nicht bekannt' %>"/><span><%t Order.UnknownTV 'Dose noch nicht bekannt' %></span></a></div>
		          </div>
		        </div>
				
				$UnknownDoseForm
				
		        <% with OrderConfig %>
		        <div id="Kabel-TV-Dose-modal" data-uk-modal>
		            <div class="uk-modal-dialog uk-modal-body">
		                    <h2 class="uk-modal-title">$KabelTVDoseModalTitle</h2>
		                    <div class="dk-text-content">$KabelTVDoseModalContent</div>
		                    <p class="uk-text-right">
		                        <button class="uk-button uk-button-primary uk-modal-close" type="button"><%t General.Close 'Schliessen' %></button>
		                    </p>
		                </div>
		        </div>
		        <div id="Glasfaser-Dose-modal" data-uk-modal>
		            <div class="uk-modal-dialog uk-modal-body">
		                    <h2 class="uk-modal-title">$GlasfaserDoseModalTitle</h2>
		                    <div class="dk-text-content">$GlasfaserDoseModalContent</div>
		                    <p class="uk-text-right">
		                        <button class="uk-button uk-button-primary uk-modal-close" type="button"><%t General.Close 'Schliessen' %></button>
		                    </p>
		                </div>
		        </div>
		        <% end_with %>
				<% end_if %>
				<div id="products-container"  <% if activePLZ.AlternateOffer %>hidden data-has-alternative="true"<% end_if %>>
					<% if activePLZ.AlternateOffer %>
					<div class="uk-margin-large-top">
						<h3><%t Order.Products 'Ihre Bestellung' %></h3>
					<% end_if %>
						<div id="loading-block" class="uk-text-left">
							<p><span data-uk-spinner="ratio: 2" class="uk-margin-right"></span>Produkte werden geladen. Einen Moment bitte.</p>
						</div>
						<div id="products-hidden-container">
							<div class="uk-grid-small uk-grid-match" data-uk-grid>
								<div class="uk-width-2-3@m">
									<div id="categories-slider">
										<% if not activePLZ.AlternateOffer %>
										<% loop activeCategories %>
										<% include CategoriesSlider %>
										<% end_loop %>
										<% end_if %>
									</div>
									<div class="uk-margin uk-hidden@m">
										<a href="$ShopPage.Link" class="uk-button BlackBackground uk-display-block"><%t Configurator.Order 'Bestellen' %></a>
									</div>
									
									<div class="uk-margin">
										<div class="conditions-container">$ConditionsText</div>
									</div>
								</div>
								<div class="uk-width-expand uk-visible@m">
									<div data-uk-sticky="media:@m;offset:150;">
										<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
											<div class="uk-card-header">
												<h3 class="uk-card-title"><%t Configurator.AboLabel 'Bestellübersicht' %></h3>
											</div>
											<div class="uk-card-body order-preview">
												<div data-uk-spinner></div>
											</div>
											<div class="uk-card-footer">
												<a href="$ShopPage.Link" class="uk-button BlackBackground"><%t Configurator.Order 'Bestellen' %></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<% if activePLZ.AlternateOffer %>
					</div>
					<% end_if %>
				</div>
			<% end_if %>
		</div>
	</section>

	<% include ModalConditions %>