<div id="cart-container" class="uk-position-fixed uk-position-center-right uk-position-small" hidden>
	<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
		<div class="uk-position-top-right uk-position-small"><button type="button toggle-cart" data-uk-close></button></div>
		<div class="uk-card-header">
			<h3 class="uk-card-title"><%t Webshop.Cart 'Einkaufswagen' %></h3>
		</div>
		<div class="uk-card-body order-preview">
			<% include ShopCartProducts %>
		</div>
		<div class="uk-card-footer">
			<a href="$ShopPage.Link" class="uk-button BlackBackground"><%t Webshop.Checkout 'Zur Kasse' %></a>
		</div>
	</div>
</div>
