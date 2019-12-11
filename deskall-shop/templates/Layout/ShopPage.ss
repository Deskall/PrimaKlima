$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<% if CurrentUser %>
	$CheckoutForm
	<% else %>
	<div class="uk-container">
		
			<a><%t Checkout.Login 'Sie besitzen bereits ein Konto? Weiter zum<div class="uk-h1">Login</div>' %></a></li>
			<a href="$RegisterPage('arbeitgeber').Link"><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur<div class="uk-h1">Neu-Registrierung</div>' %></a></li>
		
			$LoginForm
			
		
	</div>
	<% end_if %>
</section>
