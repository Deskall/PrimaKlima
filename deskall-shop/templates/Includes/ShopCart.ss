<div id="cart-container" class="uk-position-fixed uk-position-center-right uk-position-z-index sidebar-menu">
	<div id="offcanvas-usage-cart">
		<div class="uk-offcanvas-bar dk-middle-offcanvas cart-offcanvas">
			<button class="uk-offcanvas-close" type="button" data-uk-close></button>
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
