<div id="cart-container" class="uk-position-fixed uk-position-center-right uk-position-z-index sidebar-menu">
	<div id="offcanvas-usage-cart" hidden>
		<div class="dk-middle-offcanvas cart-offcanvas">
			<button class="uk-offcanvas-close" type="button" data-uk-toggle="target: #offcanvas-usage-cart" data-uk-close></button>
			<div class="uk-card uk-background-muted uk-card-hover uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header">
					<h3 class="uk-card-title"><%t Webshop.Cart 'Warenkorb' %></h3>
				</div>
				<div class="uk-card-body order-preview dk-text-small">
					<% include ShopCartProducts %>
				</div>
				<div class="uk-card-footer">
					<a href="$ShopPage.Link" class="uk-button button with-chevron uk-width-1-1"><%t Webshop.Checkout 'Zur Kasse' %></a>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div id="mobile-cart-container" class="uk-hidden@m">
		<div class="cart-container">
			<div class="uk-card uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header toggle-cart uk-padding-remove-horizontal" data-target="#mobile-order-preview">
					<div class="uk-position-relative">
						<strong class="uk-card-title uk-padding-small"><%t Webshop.Cart 'Warenkorb' %></strong>
						<div class="uk-position-absolute uk-position-center-right">
							<button type="button" class="cart-button"><span data-uk-icon="icon:chevron-down;ratio:1.5"></span></button>
							<button type="button" class="cart-button uk-hidden"><span data-uk-icon="icon:chevron-up;ratio:1.5"></span></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="mobile-order-preview" hidden>
		<div class="uk-card-body order-preview dk-text-small">
			<% include ShopCartProducts %>
		</div>
		<div class="uk-card-footer">
			<a href="$ShopPage.Link" class="uk-button button with-chevron uk-width-1-1"><%t Webshop.Checkout 'Zur Kasse' %></a>
		</div>
	</div>