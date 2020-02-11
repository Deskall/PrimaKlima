<div class="uk-container">
		<ul class="member-tab uk-child-width-expand uk-visible@m" data-uk-tab>
			<li class="uk-text-left"><a><%t Checkout.Login 'Sie besitzen bereits ein Konto? Weiter zum<div class="uk-h1">Login</div>' %></a></li>
			<li><a><%t Checkout.Register 'Sie besitzen noch kein Konto? Weiter zur<div class="uk-h1">Neu-Registrierung</div>' %></a></li>
		</ul>
		<ul id="login-tab-switcher" class="uk-switcher">
			<li class="account-tab">
				<div class="uk-panel uk-background-muted uk-padding-small">
					<h1 class="uk-hidden@m uk-h1"><%t MemberPage.LoginTitle 'Login' %></h1>
					<p><%t Checkout.LoginLabel 'Melden Sie sich hier mit Ihren persönlichen Zugangsdaten an.' %></p>
					<p class="uk-hidden@m"><%t MemberPage.RegisterMobile 'Sie besitzen noch kein Konto? Weiter zur <a data-toggle-login-switcher="1">Neu-Registrierung</a>' %></p>
					$LoginForm
				</div>
			</li>
			<li class="account-tab">
				<div class="uk-panel uk-background-muted uk-padding-small">
					<h1 class="uk-hidden@m uk-h1"><%t MemberPage.RegisterTitle 'Neu-Registrierung' %></h1>
					<p><%t Checkout.RegisterLabel 'Erstellen Sie hier ein neues Profil, um Zugriff auf Ihren persönlcihen Bereich zu erhalten.' %></p>
					<p class="uk-hidden@m"><%t MemberPage.LoginMobile 'Sie besitzen bereits ein Konto? Weiter zum <a data-toggle-login-switcher="0">Login</a>' %></p>
					$RegisterForm
				</div>
			</li>
		</ul>
	</div>