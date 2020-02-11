<div class="uk-container">
		<ul class="member-tab uk-child-width-expand uk-visible@m" data-uk-tab>
			<li class="uk-text-left"><a><%t Checkout.Login 'Sie besitzen bereits ein Konto? Weiter zum<div class="uk-h1">Login</div>' %></a></li>
			<li><a><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur<div class="uk-h1">Neu-Registrierung</div>' %></a></li>
		</ul>
		<ul class="uk-switcher">
			<li class="account-tab">
				<div class="uk-panel uk-background-muted uk-padding-small">
					<h1 class="uk-hidden@m"><%t MemberPage.LoginTitle 'Login' %></h1>
					<p><%t Checkout.LoginLabel 'Melden Sie sich hier mit Ihren persönlichen Zugangsdaten an.' %></p>
					<p class="uk-hidden@m"><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur <a>Neu-Registrierung</a>' %></p>
					$LoginForm
				</div>
			</li>
			<li class="account-tab">
				<div class="uk-panel uk-background-muted uk-padding-small">
					<p><%t Checkout.RegisterLabel 'Erstellen Sie hier ein neues Profil, um Zugriff auf Ihren persönlcihen Bereich zu erhalten.' %></p>
					
					$RegisterForm
					
				</div>
			</li>
		</ul>
			
		
	</div>