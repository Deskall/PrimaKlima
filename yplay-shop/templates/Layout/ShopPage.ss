
	<section class="uk-section uk-section-medium">
		<div class="uk-container uk-container-medium">
			<h1>$Title</h1>
			<div class="uk-grid-small" data-uk-grid>
				<div class="uk-width-2-3@m">
					<ul data-uk-accordion>
					    <li class="uk-open">
					        <a class="uk-accordion-title" href="#">Item 1</a>
					        <div class="uk-accordion-content">
					            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
					        </div>
					    </li>
					    <li>
					        <a class="uk-accordion-title" href="#">Item 2</a>
					        <div class="uk-accordion-content">
					            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
					        </div>
					    </li>
					    <li>
					        <a class="uk-accordion-title" href="#">Item 3</a>
					        <div class="uk-accordion-content">
					            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat proident.</p>
					        </div>
					    </li>
					</ul>
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

