
	<section class="uk-section uk-section-medium">
		<div class="uk-container uk-container-medium">
			<h1>$Title</h1>
			<div class="uk-grid-small" data-uk-grid>
				<div class="uk-width-2-3@m">
					$OrderForm
				<%-- <form>
					<ul data-uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: true" uk-tab>
					    <li><a href="#">1</a></li>
					    <li><a href="#" disabled="disabled">2</a></li>
					    <li><a href="#">3</a></li>
					</ul>

					<ul class="uk-switcher uk-margin">
					    <li>
					    	<h2><%t ShopPage.CustomerSectionTitle 'Sind Sie bereits Kunde?' %></h2>
					    	<label><input type="radio" name="customer" class="uk-radio" value="Ja">Ja</label>
					    	<label><input type="radio" name="customer" class="uk-radio" value="Nein">Nein</label>
						</li>
					    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
					    <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sed do eiusmod.</li>
					</ul>
				</form> --%>
				</div>
				<div class="uk-width-expand uk-visible@m">
					<div data-uk-sticky="media:@m;bottom:true;">
						<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
							<div class="uk-card-header">
								<h3 class="uk-card-title"><%t Configurator.AboLabel 'Bestellübersicht' %></h3>
							</div>
							<div class="uk-card-body order-preview">
								
							</div>
							<div class="uk-card-footer">
								<a href="$ConfiguratorPage.Link" class="uk-button BlackBackground"><%t Configurator.Change 'Ändern' %></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-hidden@m">
				<div class="uk-position-fixed uk-position-bottom uk-position-z-index">
					<div class="uk-card uk-box-shadow-medium uk-card-small">
						<div class="uk-card-header BlackBackground">
							<div class="uk-position-relative">
								<strong class="uk-card-title"><%t Configurator.AboLabel 'Bestellübersicht' %> - CHF 65.- / Mt.</strong>
								<div class="uk-position-absolute uk-position-right">
									<button type="button" data-uk-toggle="target: #mobile-order-preview; animation: uk-animation-slide-up" data-uk-icon="chevron-up"></button>
								</div>
							</div>
						</div>
						<div id="mobile-order-preview" class="uk-card-body WhiteBackground order-preview" hidden>
						</div>
						<div class="uk-card-footer BlackBackground">
							<a href="$ConfiguratorPage.Link" class="uk-button uk-button-primary uk-display-block"><%t Configurator.Change 'Ändern' %></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

