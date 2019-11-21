
<% if CurrentMember %>


<section class="account-page-holder block-holder">
	<div class="container">
		<div class="col w-12">
		<h1>$Title</h1>


		<% if $GetUserData(ClassName) == "Cook" %>

		<div class="lead-block text-block clearfix">
			<div class="lead">
				Hallo $GetUserData(FirstName) $GetUserData(Surname)!<br/>Herzlich willkommen in Ihrem persönlichen Köcheportal-Bereich. Hier können Sie ein eigenes Profil erstellen, Ihre Angaben ändern und Ihr Konto verwalten. 
			</div>
		</div>

		<% if $UserConfirmationOpen %>
			<div class="message warning">
				<p>Ihre E-Mail wurde noch nicht bestätigt. Klicken Sie dazu im erhaltenen E-Mail auf den entsprechenden Link.</p>
				<p><a href="/account/sendcofirmation" data-send-confirmation>Neue Besteätigungs-Email senden</a></p>
			</div>
		<% end_if %>
<%--
		<div class="form-cook-function clearfix" data-auto-submit-form>
			$CookFunctionForm
		</div>
--%>
		<div class="tab-holder" data-tab-holder>
			<div class="header clearfix cook-nav">
				<a href="#personal" data-show-tab class="active">1. Personalien</a>
				<a href="#professional" data-show-tab>2. Berufliche Angaben</a>
				<a href="#documents" data-show-tab>3. Dokumente</a>
				<a href="/cook/detail/candidate/$GetUserData(ID)">4. Profil-Vorschau</a>
				<a href="#applications" data-show-tab>5. Meine Bewerbungen</a>

			</div>

			<div class="contents clearfix">
				<div class="tab active" data-tab id="personal">
					<h2>Personalien</h2>
					<p>1.Schritt: Füllen Sie alle Felder gemäss Vorgabe aus, und speichern Sie die Seite</p>
					$CookPersonalDataForm
				</div>

				<div class="tab" data-tab id="professional">
					<h2>Berufliche Angaben</h2>
					<p>2. Schritt: Füllen Sie die Felder gemäss Vorgabe aus. Ihren Lebenslauf/Ihre bisherigen Mietkoch-Einsätze können Sie sich einfach in wenigen Klicks mit den untenstehenden Formularen zusammenstellen. Alle Angaben speichern.</p>
					$CookProfessionalDataForm
				</div>

				<div class="tab" data-tab id="documents">
					<h2>Dokumente</h2>
					<p>Nächster Schritt: Laden Sie hier alle benötigen Dokumente (Zeugnisse, etc.) herunter. Danach speichern.</p>
					$CookDocumentsForm
				</div>

				<div class="tab" data-tab id="applications">
					<h2>Bewerbungen</h2>
					<p>Hier finden Sie Ihre laufenden Bewerbungen im Überblick</p>
					<div class="tbl-wrapper">
					<table class="applications cook-view">
						<tr>
							<th>Arbeitgeber</th>
							<th>Inserat</th>
							<th>Status</th>
							<th>Datum</th>
						</tr>


					<% loop $Applications %>

						<tr data-ad="$ID" <% if not $isRead %>class="open"<% end_if %> >
							<td>$EmployerAdvertisement.Employer.Company</td>
							<td>$EmployerAdvertisement.ContentTitle</td>
							<td><% if $isRead %>gelesen<% else %>ungelesen<% end_if %></td>
							<td>$CreatenDate</td>
						</tr>

					<% end_loop %>
					</table>
					</div>

					<script id="application-overlay-template" type="text/x-handlebars-template">
						<div class="overlay large" data-overlay>
							<div class="overlay-content">
								<div class="overlay-header">
									{{ Title }}
									<a class="close-overlay" data-overlay-close></a>
								</div>
								<div class="overlay-content-holder cook application-detail">{{{ Content }}}</div>
							</div>
						</div>
					</script>

				</div>


			</div>
		</div>
		<% end_if %>


		<% if $GetUserData(ClassName) == "Employer" %>

		<div class="lead-block text-block clearfix">
			<div class="lead">
				<p>Hallo $GetUserData(FirstName) $GetUserData(Surname) !<br/>Herzlich willkommen in Ihrem persönlichen Köcheportal-Bereich. Hier können Sie Ihre Firmenangaben anpassen, Inserate buchen und erfassen.</p>
			</div>
		</div>

		<% if $UserConfirmationOpen %>
			<div class="message warning">
				<p>Ihre E-Mail wurde noch nicht bestätigt. Klicken Sie dazu im Erhaltenen E-Mail auf den entsprechenden Link.</p>
				<p><a href="/account/sendcofirmation" data-send-confirmation>Neue Besteätigungs-Email senden</a></p>
			</div>
		<% end_if %>


		<% if not $AdsAvailable %>


			<% if $hasOpenOrder %>

			<div class="message warning">
				<h4>Keine Inserate verfügbar</h4>
				<p>Achtung, Sie können derzeit keine neuen Inserate mehr schalten, da Sie noch unbezahlte Rechnungen offen haben.</p>
				<p>Sobald diese bezahlt sind, können Sie Ihre Inserate freischatlen</p>
			</div>

			<% else %>

			<div class="message warning">
				<h4>Keine Inserate verfügbar</h4>
				<p>Achtung, Sie können derzeit keine neuen Inserate mehr schalten. Buchen Sie ein neues Paket, um weitere Inserate schalten zu können.</p>
				<a data-show-order href="#order-holder">Jetzt Paket buchen </a>
			</div>

			<% end_if %>
			

		<% end_if %>


			<% if $OpenApplications.Count > 0 %>
			<div class="message success">
				<% if $OpenApplications.Count > 1 %>
				<h4>Neue Bewerbungen erhalten</h4>
				<p>Sie haben $OpenApplications.Count neue, ungelesene Bewerbungen erhalten.</p>
				<% else %>
				<h4>Neue Bewerbung erhalten</h4>
				<p>Sie haben eine neue, ungelesene Bewerbung erhalten.</p>
				<% end_if %>
				<a href="#applications">Zu den Bewerbungen </a>
			</div>
			<% end_if %>



		<div class="order-holder hidden" id="order-holder"  >
			<div class="package-order">
				<div class="price-block clearfix">
				<% loop $PackageData %>

					<% if First %>
						<div class="packaage-item attr-holder">
					<% else %>
						<a class="packaage-item package-holder package-{$PackageCode}" data-package-id="$ID">
					<% end_if %>

						<div class="row title" data-package-title>$Title <br/></div>
						<div class="row">$RunTime</div>
						<div class="row">$NumOfAds</div>

						<% loop $Features.Sort('SortOrder') %>
							<% if $Title__de_DE == 'y' %>
								<div class="row"><span class="icon-checkmark-round"></span></div>
							<% else_if $Title__de_DE == 'n' %>
								<div class="row">-</div>
							<% else %>
								<div class="row">$Title__de_DE</div>
							<% end_if %>
						<% end_loop %>


						<% if $Price > 0 %>
						<div class="row price" data-price="$Price">$Price €</div>
						<% else %>
						<div class="row price-options">

							<% if $PriceOptions.Count > 0 %>

							<select data-option>
								
							<% loop $PriceOptions %>
								<% if $Price > 0 %>
								<option value="$ID" data-price="$Price" data-duration="$Title">$Title à $Price €</option>
								<% end_if %>
							<% end_loop %>

							</select>

							<% end_if %>



						</div>
						<% end_if %>

						<% if  not First %>
						<div class="row cta-hoder">
							<span href="#" class="btn-buy" data-update-order>Jezt buchen</span>
						</div>
						<% end_if %>

					<% if First %>
						</div>
					<% else %>
						</a>
					<% end_if %>
				<% end_loop %>

				</div>
				<p class="note">alle Preise gelten pro Betriebsstätte, und sind Endpreise ohne MWST (Firmensitz in CH)<br/>Preise für Hotelkonzerne erhalten Sie gerne auf Anfrage.Für Persönliche Personalvermittlung (Headhunting) berechnen wir Ihnen eine Provision von 15% des Jahres-Bruttolohns für folgende Leistungen: Sie bekommen Sie ausgewählte und geprüfte Bewerber für Ihr vakante Position, nach Ihrem Anforderungsprofil.</p>
			</div>


			<form class="summary-holder hidden clearfix" action="/order/neworder" data-package-order-form >
				<div class="summary" id="order-summary"></div>
				<div class="coupon-holder">
					<div class="inline-field"><label>Gutschein-Code<input type="text" data-coupon /></label></div><button  data-verify-coupon>Prüfen</button >
				</div>

				<div class="conditions">
					<label><input type="checkbox" name="condition" id="accept-conditions" />Ich erkläre mich mit den AGB von Köcheportal einverstanden.</label>
				</div>

				<button class="btn-order hidden" disabled id="btn-order">Jetzt kostenpflichtig bestellen</button>

			</form>



			<script id="order-summary-template" type="text/x-handlebars-template">
				<p>Ich bestelle das Paket <strong>{{Package.Title}}</strong> {{#if Package.Duration}}für {{Package.Duration}} {{/if}}zu einem einmaligen Preis von {{Package.Price}} € . </p>
				{{#if Package.Reduction}} <p>Abzüglich Gutschein-Reduktion von {{ Package.Reduction }}: {{ Package.ReducedPrice }} €</p>{{/if}}
				<p><strong>Rechnungadresse</strong><br/>
				{{ Address.Company }}<br/>
				{{ Address.Street }}<br/>
				{{ Address.Postal }} {{ Address.Place }}<br>
				{{ Address.Country }}</p>
			</script>
		</div>

		<div class="tab-holder" data-tab-holder>
			<div class="header clearfix">
				<a href="#address" data-show-tab class="active">1. Adressangaben erfassen</a>
				<a href="#portrait" data-show-tab>2. Firmenporträt erstellen</a>
				<a href="#orders" data-show-tab>3. Paket bestellen</a>
				<a href="#advertisements" data-show-tab>4. Inserate erstellen</a>
				<a href="#applications" data-show-tab>5. Bewerbungen verwalten</a>

			</div>

			<div class="contents clearfix">
				<div class="tab active" data-tab id="address">
					<h2>Adressangaben</h2>
					<p>1.Schritt: Füllen Sie alle Felder gemäss Vorgabe aus, und speichern Sie die Seite.</p>
					$EmployerAddressForm
				</div>

				<div class="tab" data-tab id="portrait">
					<h2>Firmenporträt</h2>
					<p>2.Schritt: Füllen Sie alle Felder gemäss Vorgabe aus, und speichern Sie die Seite. </p>
					$EmployerPortraitForm
				</div>

				<div class="tab" data-tab id="advertisements">
					<h2>Inserate</h2>

					<p>Zur Erstellung Ihres Inserats wählen Sie <strong>Inserat hinzufügen</strong>. Füllen Sie in der Eingabemaske die einzelnen Seiten aus und speichern Sie sie. Das Inserat wird nun automatisch aufgrund der Textbausteine erstellt und ist als Vorschau verfügbar. <strong>Achtung: nach der Freischaltung sind keine Änderungen mehr möglich. </strong></p>

					$AdAvailabilityString
					<div class="tbl-wrapper">$EmployerAdvertisementsForm</div>
				</div>

				<div class="tab" data-tab id="applications">
					<h2>Bewerbungen</h2>
					<p>Hier können Sie sämtliche eingegangenen Bewerbungen bequem online einsehen und direkt beantworten.</p>
					<div class="tbl-wrapper">
						<table class="applications">
							<tr>
								<th>Bewerber</th>
								<th>Inserat</th>
								<th>Datum</th>
							</tr>


						<% loop $Applications %>

						
							<tr data-ad="$ID" <% if not $isRead %>class="open"<% end_if %> >
								<td>$CookName</td>
								<td>$EmployerAdvertisement.Title</td>
								<td>$CreatenDate</td>
							</tr>


						<% end_loop %>
						</table>
					</div>

					<script id="application-overlay-template" type="text/x-handlebars-template">
						<div class="overlay large" data-overlay>
							<div class="overlay-content">
								<div class="overlay-header">
									{{ Title }}
									<a class="close-overlay" data-overlay-close></a>
								</div>
								<div class="overlay-content-holder cook application-detail">{{{ Content }}}</div>
							</div>
						</div>
					</script>

				</div>






				<div class="tab" data-tab id="orders">
					<h2>Bestellung</h2>
					<a class="create-order" data-show-order href="#order-holder">Paket bestellen</a>
					<div class="tbl-wrapper">
						<table class="user-orders">
							<tr>
								<th>Paket</th>
								<th>Bestelldatum</th>
								<th>Status</th>
								<th>Nummer</th>
								<th>Rechnung</th>
							</tr>

							<% loop $GetUserOrders.Sort('Created DESC') %>
							<tr>
								<td>$Title</td>
								<td>$Created.Format('d.m.Y') Uhr</td>
								<td><% if $isPaid %>bezahlt<% else %>Bezahlung offen<% end_if %></td>
								<td>$generateOrderNumber</td>
								<td><a href="/order/invoice/$ID" class="download-invoice" target="_blank"></a></td>
							</tr>
							<% end_loop %>


						</table>
					</div>
				</div>


			</div>

		</div>
		<% end_if %>


		</div>
	</div>
</section>


<% else %>




<section class="block-holder text-block no-padding-bottom" >
	<div class="container">
		<div class="col w-12">
			<div class="blocks clearfix <% if $hasBorder %>bottom-border<% end_if %>" id="$PrintURLSegment">
				<h1>Anmelden</h1>
				<div class="lead">
					$Content
				</div>

			</div>
		</div>
	</div>
</section>

<section class="login-page-holder block-holder">




	<div class="container">

		<div class="col w-12">
			<div class="login-tab-holder" data-tab-holder>
				<div class="header clearfix">
					<a href="#login" data-show-tab class="login-tab-button active">
						<span class="subtitle">Sie besitzen bereits ein Konto? Weiter zum</span>
						<span class="title">Login</span>
					</a>

					<a href="#register" data-show-tab class="login-tab-button">
						<span class="subtitle">Sie besitzen noch kein Konto? Weiter zur</span>
						<span class="title">Neu-Registrierung</span>
					</a>
				</div>


				<div class="contents clearfix">
					<div class="tab active login" data-tab id="login">
						<p>Melden Sie sich hier mit Ihren persönlichen Zugangsdaten an.</p>
						$LoginForm
					</div>

					<div class="tab register" data-tab id="register">
						<p>Erstellen Sie hier ein neues Profil, um Zugriff auf Ihren persönlcihen Bereich zu erhalten.</p>
						$RegistrationForm
					</div>
				</div>
			</div>	

		</div>



	</div>


</section>


<% end_if %>






