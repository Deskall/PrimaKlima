$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<% if CurrentUser %>
	$CheckoutForm
	<% else %>
	<div class="uk-container">
		<ul id="tab-switcher" data-uk-tab="connect: #account-tab; animation: uk-animation-fade">
			<li class="uk-active"><a><%t Checkout.Login 'Sie besitzen bereits ein Konto? Weiter zum<div class="uk-h1">Login</div>' %></a></li>
			<li><a><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur<div class="uk-h1">Neu-Registrierung</div>' %></a></li>
		</ul>
		<ul id="account-tab" class="uk-switcher">
			<li>$LoginForm
			</li>
			<li>
				<% with $getRegisterPage %>
				$ID
				$RegisterForm
				<% end_with %>
			</li> 
		</ul>
	</div>
	<% end_if %>
</section>
