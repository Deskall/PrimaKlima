$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<% if CurrentUser %>
	$CheckoutForm
	<% else %>
	<div class="uk-container">
		<ul data-uk-tab class="uk-margin-remove">
			<li class="uk-text-left"><a><%t Checkout.Login 'Sie besitzen bereits ein Konto? Weiter zum<div class="uk-h1">Login</div>' %></a></li>
			<li><a><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur<div class="uk-h1">Neu-Registrierung</div>' %></a></li>
		</ul>
		<ul class="uk-switcher">
			<li class="account-tab">
				<div class="uk-panel PrimaryBackground uk-padding-small">
					<p><%t Checkout.LoginLabel 'Melden Sie sich hier mit Ihren persönlichen Zugangsdaten an.' %></p>
					$LoginForm
				</div>
			</li>
			<li class="account-tab">$RegisterForm</li>
		</ul>
			
		
	</div>
	<% end_if %>
</section>
