	<div class="uk-hidden@m">
		<div class="cart-container">
			<div class="uk-card uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header BlackBackground toggle-cart" data-target="#mobile-order-preview">
					<div class="uk-position-relative">
						<strong class="uk-card-title"><%t Configurator.CartLabel 'Warenkorb' %> - $activeCart.TotalMonthlyPrice</strong>
						<div class="uk-position-absolute uk-position-center-right">
							<button type="button"><span data-uk-icon="icon:chevron-down;ratio:1.5"></button>
							<button type="button" hidden><span data-uk-icon="icon:chevron-up;ratio:1.5"></button>
						</div>
					</div>
				</div>
				<div id="mobile-order-preview" hidden>
					<div class="uk-card-body WhiteBackground order-preview">
					</div>
					<div class="uk-card-footer BlackBackground">
					<a href="$ConfiguratorPage.Link" class="uk-button uk-button-primary uk-display-block"><%t Configurator.Change 'Ändern' %></a>
				</div>
				</div>
				
			</div>
		</div>
	</div>
	<section class="uk-section uk-section-medium">
		<div class="uk-container uk-container-medium">
			<h1>$Title</h1>
			<div class="uk-grid-small" data-uk-grid>
				<div class="uk-width-2-3@m">
					$OrderForm
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
			
		</div>
	</section>

