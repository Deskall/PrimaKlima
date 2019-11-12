<section class="advertisements block-holder">
	<div class="container">

		<div class="col w-12">

			<h1>$Title</h1>

			<form class="filter-holder clearfix" data-ad-filter action="/ad/listing/" >
				<strong><%t FinderBar.SearchTitle 'Suche' %>:</strong>
				<div class="select-holder inline">
					<select data-chosen-filter name="position" data-placeholder="<%t FinderBar.Position 'Position' %>">
						<option value=""></option>
						<% loop $getPositions.Sort('Title') %>
							<% if $Title %>
							<option value="$Value" <% if $Selected %>selected<% end_if %>>$Title</option>
							<% end_if %>
						<% end_loop %>
					</select>
				</div>
				<div class="select-holder inline">
					<select data-chosen-filter name="postal" data-placeholder="<%t FinderBar.Place 'Ort' %>">
						<option value=""></option>
						<% loop $getPostals.Sort('Title') %>
							<% if $Title %>
							<option value="$Value" <% if $Selected %>selected<% end_if %>>$Title</option>
							<% end_if %>
						<% end_loop %>
					</select>

				</div>


<%--

				<label>PLZ: <input data-ad-filter="postal" value="$FilterPostal"/></label>
				<label>Position: <input data-ad-filter="position" value="$FilterPosition"/></label>
--%>
				<button data-ad-filter-apply >Filter anwenden</button>
			</form>


			<% if $Advertisements.Count > 0 %>

			<div class="item-holder">
				<% loop $Advertisements %>

					<a href="/ad/detail/$ID" class="item">
						<span class="title">$ContentTitle </span>
						<span class="information">
							<span class="company">$Employer.Company</span>
							<span class="address">$Employer.AddressPostalCode $Employer.AddressPlace, $Employer.AddressCountry</span>
						</span>	
						<span class="link-more">Zum Inserat</span>
					</a>

<%--
					<% if $Top.CookLoggedIn  %>
					<a href="/ad/detail/$ID" class="item">
						<span class="title">$ContentTitle </span>
						<span class="information">
							<span class="company">$Employer.Company</span>
							<span class="address">$Employer.AddressPostalCode $Employer.AddressPlace, $Employer.AddressCountry</span>
						</span>	
						<span class="link-more">Zum Inserat</span>
					</a>

					<% else %>

					<a data-open-cook-login="$ID" class="item">
						<span class="title">$ContentTitle </span>
						<span class="information">
							<span class="address">$Employer.AddressPostalCode $Employer.AddressPlace, $Employer.AddressCountry</span>
						</span>	
						<span class="link-more">Für Details bitte anmelden</span>
					</a>

					<% end_if %>
--%>



				<% end_loop %>
			</div>


			<% else %>

			<div class="msg">Keine passenden Stellenagebote gefunden.</div>


			<% end_if %>


		</div>


	</div>
</section>



<% if not $CookLoggedIn %>

<script id="cook-login-template" type="text/x-handlebars-template">
  <div class="overlay" data-overlay>
  	<a class="overlay-close" data-overlay-close></a>

  	<div class="overlay-content">
  		<form class="overlay-form " action="/ad/login/" method="post">

  			<h2>Bitte anmelden</h2>
  			<p>Dieser Bereich steht nur angemeldeten Köchen zur Verfügung</p>
  			<input type="hidden" name="redirect" value="{{id}}" />
		
			<input type="hidden" name="AuthenticationMethod" value="CustomerAuthenticator" class="hidden" id="CustomerLoginForm_LoginForm_AuthenticationMethod">
			
			<input type="text" name="Email" class="text nolabel" id="CustomerLoginForm_LoginForm_Email" required="required" aria-required="true" placeholder="E-Mail">
	
			<input type="password" name="Password" class="text password nolabel" id="CustomerLoginForm_LoginForm_Password" required="required" aria-required="true" placeholder="Passwort" autocomplete="off">
	
		
			<input type="hidden" name="SecurityID" value="e20481c1ff061515bc75f8ff8592e33e92600f25" class="hidden" id="CustomerLoginForm_LoginForm_SecurityID">
		

			<button type="submit" name="action_dologin" value="Anmelden" class="action" id="CustomerLoginForm_LoginForm_action_dologin">
		Anmelden
	</button>
		
			<p id="ForgotPassword"><a href="Security/lostpassword">Passwort vergessen?</a></p>
		



  		</form>
  	</div>

  </div>
</script>

<% end_if %>


