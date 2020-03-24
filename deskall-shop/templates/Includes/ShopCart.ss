<div class="uk-position-fixed uk-position-center-right uk-position-small">
	<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
		<button type="button" uk-close></button>
		<div class="uk-card-header">
			<h3 class="uk-card-title"><%t Webshop.Cart 'Einkaufswagen' %></h3>

		</div>
		<div class="uk-card-body order-preview">
			<% include ShopCartProducts %>
		</div>
		<div class="uk-card-footer">
			<a href="$Top.ShopPage.Link" class="uk-button BlackBackground"><%t Webshop.Checkout 'Zur Kasse' %></a>
		</div>
	</div>
</div>
