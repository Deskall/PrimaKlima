<section class="advertisement block-holder">
	<div class="container">
		<% with $Advertisement %>
		<div class="col w-12">
			<h3 class="pretitle">$ContentIntro</h3>
			<h1>$ContentTitle</h1>

		</div>
		<div class="col w-8 ad-content">

			<% if $Picture %><img src="$Picture.URL" alt="$Title" title="$Title" class="img-large" /><% end_if %>

			$ContentMain

			<% if $Attachements	%>
				<h3>Anhänge</h3>
				<% loop $Attachements %>
					<a href="$URL" target="_blank" title="$Title" class="attachement">$Title</a>
				<% end_loop %>
			<% end_if %>

		</div>

		<div class="col w-4 employer-content">
			<h3>Informationen zum Arbeitgeber</h3>

			<% if $Employer.Picture %><img src="$Employer.Picture.URL" alt="$Employer.Company" title="$Employer.Company" class="logo"/><% end_if %>

			<div class="address">
				<p><strong>$Employer.Company</strong></p>
				<p>$Employer.AddressStreet<br/>$Employer.AddressPostalCode $Employer.AddressPlace <br/>$Employer.AddressCountry</p>
				<% if $Employer.Email %><a class="btn btn-email" href="mailto:$Employer.Email">$Employer.Email</a><% end_if %>
				<% if $Employer.Telephone %><a class="btn btn-phone" href="tel:$Employer.Telephone">$Employer.Telephone</a><% end_if %>
				<% if $Employer.Homepage %><a class="btn btn-web" href="$Employer.Homepage" target="_blank">$Employer.Homepage</a><% end_if %>
			</div>

			<div class="social clearfix">
				<% if $Employer.SocialFacebook %><a class="item facebook" href="$Employer.SocialFacebook" target="_blank"></a><% end_if %>
				<% if $Employer.SocialTwitter %><a class="item twitter" href="$Employer.SocialTwitter" target="_blank"></a><% end_if %>
				<% if $Employer.SocialInstagram %><a class="item instagram" href="$Employer.SocialInstagram" target="_blank"></a><% end_if %>
				<% if $Employer.SocialPinterest %><a class="item pinterest" href="$Employer.SocialPinterest" target="_blank"></a><% end_if %>
			</div>

			<% if $Employer.Offers %>
			<div class="offer-list">
				<h3>Was wir bieten:</h3>
				<ul>
				<% loop $Employer.Offers %>
					<li>$Title__de_DE</li>
				<% end_loop %>
				</ul>
			</div>
			<% end_if %>

			<% if $Employer.Infrastructure %>
			<div class="offer-list">
				<h3>Infrastruktur:</h3>
				<ul>
				<% loop $Employer.Infrastructure %>
					<li>$Title__de_DE</li>
				<% end_loop %>
				</ul>
			</div>
			<% end_if %>

			<% if $Employer.ReasonWhy %>
			<div class="reason-why">
				<h3>Warum Sie bei uns arbeiten sollten:</h3>
				<div class="content">
					$Employer.ReasonWhy
				</div>
			</div>
			<% end_if %>
		</div>



		<% if $Top.CookLoggedIn %>
		<div class="col w-12">
		<div class="application-holder">
			<a class="get-application-form" data-get-application-form>Jetzt bewerben</a>			

			<div class="form-holder" data-application-form>
				
				$ApplicationForm

			</div>
		</div>
		</div> 
		<% end_if %>



<%----






		<% if $Top.CookLoggedIn %>

		<div class="col w-8 ad-content">

			<% if $Picture %><img src="$Picture.URL" alt="$Title" title="$Title" class="img-large" /><% end_if %>

			$ContentMain

			<% if $Attachements	%>
				<h3>Anhänge</h3>
				<% loop $Attachements %>
					<a href="$URL" target="_blank" title="$Title" class="attachement">$Title</a>
				<% end_loop %>
			<% end_if %>

		</div>

		<div class="col w-4 employer-content">
			<h3>Informationen zum Arbeitgeber</h3>

			<% if $Employer.Picture %><img src="$Employer.Picture.URL" alt="$Employer.Company" title="$Employer.Company" class="logo"/><% end_if %>

			<div class="address">
				<p><strong>$Employer.Company</strong></p>
				<p>$Employer.AddressStreet<br/>$Employer.AddressPostalCode $Employer.AddressPlace <br/>$Employer.AddressCountry</p>
				<% if $Employer.Email %><a class="btn btn-email" href="mailto:$Employer.Email">$Employer.Email</a><% end_if %>
				<% if $Employer.Telephone %><a class="btn btn-phone" href="tel:$Employer.Telephone">$Employer.Telephone</a><% end_if %>
				<% if $Employer.Homepage %><a class="btn btn-web" href="$Employer.Homepage" target="_blank">$Employer.Homepage</a><% end_if %>
			</div>

			<div class="social clearfix">
				<% if $Employer.SocialFacebook %><a class="item facebook" href="$Employer.SocialFacebook" target="_blank"></a><% end_if %>
				<% if $Employer.SocialTwitter %><a class="item twitter" href="$Employer.SocialTwitter" target="_blank"></a><% end_if %>
				<% if $Employer.SocialInstagram %><a class="item instagram" href="$Employer.SocialInstagram" target="_blank"></a><% end_if %>
				<% if $Employer.SocialPinterest %><a class="item pinterest" href="$Employer.SocialPinterest" target="_blank"></a><% end_if %>
			</div>

			<div class="offer-list">
				<h3>Was wir bieten:</h3>
				<ul>
				<% loop $Employer.Offers %>
					<li>$Title__de_DE</li>
				<% end_loop %>
				</ul>
			</div>

			<div class="offer-list">
				<h3>Infrastruktur:</h3>
				<ul>
				<% loop $Employer.Infrastructure %>
					<li>$Title__de_DE</li>
				<% end_loop %>
				</ul>
			</div>

			<div class="reason-why">
				<h3>Warum du bei uns arbeiten solltest:</h3>
				<div class="content">
					$Employer.ReasonWhy
				</div>
			</div>

		</div>


		<% else %>


		<div class="col w-12 login-page-holder ">

			<p>Dieser Bereich steht nur eingeloggten Köchen zur Verfügung</p>

<form id="CustomerLoginForm_LoginForm" action="/ad/login" method="post" enctype="application/x-www-form-urlencoded">

	
	<p id="CustomerLoginForm_LoginForm_error" class="message " style="display: none"></p>
	

	<fieldset>
		
		
			<input type="hidden" name="AuthenticationMethod" value="CustomerAuthenticator" class="hidden" id="CustomerLoginForm_LoginForm_AuthenticationMethod">
		
			<div id="CustomerLoginForm_LoginForm_Email_Holder" class="field text nolabel">
	
	<div class="middleColumn">
		<input type="text" name="Email" class="text nolabel" id="CustomerLoginForm_LoginForm_Email" required="required" aria-required="true" placeholder="E-Mail oder Kunde-Nr.">
	</div>
	
	
	
</div>

		
			<div id="CustomerLoginForm_LoginForm_Password_Holder" class="field text password nolabel">
	
	<div class="middleColumn">
		<input type="password" name="Password" class="text password nolabel" id="CustomerLoginForm_LoginForm_Password" required="required" aria-required="true" placeholder="Passwort" autocomplete="off">
	</div>
	
	
	
</div>

		
			<input type="hidden" name="SecurityID" value="e20481c1ff061515bc75f8ff8592e33e92600f25" class="hidden" id="CustomerLoginForm_LoginForm_SecurityID">
		
		<div class="clear"><!-- --></div>
	</fieldset>

	
	<div class="Actions">
		
			<button type="submit" name="action_dologin" value="Anmelden" class="action" id="CustomerLoginForm_LoginForm_action_dologin">
		Anmelden
	</button>
		
			<p id="ForgotPassword"><a href="Security/lostpassword">Passwort vergessen?</a></p>
		
	</div>
	

</form>

		</div>








		<% end_if %>
--%>

		<% end_with %>

	</div>
</section>