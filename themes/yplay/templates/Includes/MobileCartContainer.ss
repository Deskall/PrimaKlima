<div class="uk-hidden@m">
		<div class="cart-container">
			<div class="uk-card uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header toggle-cart" data-target="#mobile-order-preview">
					<div class="uk-position-relative">
						<strong class="uk-card-title"><%t Configurator.CartLabel 'Warenkorb' %> - <span class="total-monthly-price">$activeCart.TotalMonthlyPrice</span></strong>
						<div class="uk-position-absolute uk-position-center-right">
							<button type="button" class="cart-button"><span data-uk-icon="icon:chevron-down;ratio:1.5"></span></button>
							<button type="button" class="cart-button uk-hidden"><span data-uk-icon="icon:chevron-up;ratio:1.5"></span></button>
						</div>
					</div>
				</div>
				<div id="mobile-order-preview" hidden>
					<div class="uk-card-body WhiteBackground order-preview">
						<% with activeCart %>
						<% include ShopCart %>
						<% end_with %>
					</div>
					<div class="uk-card-footer BlackBackground">
					<a href="$ConfiguratorPage.Link" class="uk-button uk-button-primary uk-display-block"><%t Configurator.Change 'Ändern' %></a>
				</div>
				</div>
				
			</div>
		</div>
	</div>