$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<% if CurrentUser %>
	$CheckoutForm
	<% else %>
	<div class="uk-container">
		<ul data-uk-tab>
			<li><a><%t Checkout.Login 'Sie besitzen bereits ein Konto? Weiter zum<div class="uk-h1">Login</div>' %></a></li>
			<li><a href="$RegisterPage('arbeitgeber').Link"><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur<div class="uk-h1">Neu-Registrierung</div>' %></a></li>
		</ul>
		<ul class="uk-switcher">
			<li>$LoginForm</li>
			<li>$RegisterForm</li>
		</ul>
			
		
	</div>
	<% end_if %>
</section>
