$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<% if CurrentUser %>
	$CheckoutForm
	<% else %>
	<div class="uk-container">
		<ul id="tab-switcher" data-uk-tab="connect: #account-tab; animation: uk-animation-fade">
			<li class="uk-active"><a><%t Checkout.Login '1. Paket wählen' %></a></li>
			<li><a><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zu<span class="uk-h1">Neu-Registrierung</span>' %></a></li>
		</ul>
		<ul id="account-tab" class="uk-switcher">
			<li>Login
			</li>
			<li>
				register
			</li> 
		</ul>
	</div>
	<% end_if %>
</section>
