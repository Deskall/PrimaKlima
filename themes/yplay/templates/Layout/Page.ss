	<div class="uk-hidden@m">
		<div class="cart-container">
			<div class="uk-card uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header toggle-cart" data-target="#mobile-order-preview">
					<div class="uk-position-relative">
						<strong class="uk-card-title"><%t Configurator.CartLabel 'Warenkorb' %> - <span class="total-monthly-price">$activeCart.TotalMonthlyPrice</span></strong>
						<div class="uk-position-absolute uk-position-center-right">
							<button type="button" class="cart-button"><span data-uk-icon="icon:chevron-down;ratio:1.5"></button>
							<button type="button" class="cart-button uk-hidden"><span data-uk-icon="icon:chevron-up;ratio:1.5"></button>
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

	$ElementalArea
	
	<% if $ID < 0 %> 
		<% if Form || Content %>
		<section class="uk-section">
			<div class="uk-container">
				<h1>$Title</h1>
				$Content
				$Form
			</div>
		</section>
		<% end_if %>
	<% end_if %>
	<% if $ID > 0 %> 
		<% include Sidebar %>
	<% end_if %>
