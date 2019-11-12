<section class="block-holder registration-block <% if $hasBorder %>bottom-border<% end_if %> color-$BGColor" id="$PrintURLSegment">
  <div class="container">
    <div class="col w-12">
        <% if $Title %><h2>$Title</h2><% end_if %>

        <div class="text-content">
        	$Content
        </div>

$GetForm


<%--




		<form id="Form_RegistrationForm" action="/mein-koecheportal/RegistrationForm" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset>
				<div id="Form_RegistrationForm_Email_Holder" class="field text">
					<label class="left" for="Form_RegistrationForm_Email">E-Mail</label>
					<div class="middleColumn">
						<input type="text" name="Email" class="text" id="Form_RegistrationForm_Email" required="required" aria-required="true">
					</div>
				</div>
		
				<div id="Form_RegistrationForm_Password_Holder" class="field text password">
					<label class="left" for="Form_RegistrationForm_Password">Gewünschtes Passwort</label>
					<div class="middleColumn">
						<input type="password" name="Password" class="text password" id="Form_RegistrationForm_Password" required="required" aria-required="true" autocomplete="off">
					</div>
				</div>
		
				<div id="Form_RegistrationForm_RepeatPassword_Holder" class="field text password">
					<label class="left" for="Form_RegistrationForm_RepeatPassword">Passwort wiederholen</label>
					<div class="middleColumn">
						<input type="password" name="RepeatPassword" class="text password" id="Form_RegistrationForm_RepeatPassword" autocomplete="off">
					</div>
				</div>
		
				<% if $MemberType %>
					<input type="hidden" name="MemberGroup" value="$MemberType">

				<% else %>

				<div id="MemberGroup" class="field optionset">
					<label class="left">Ich bin...</label>
					<div class="middleColumn">
						<ul class="optionset" id="Form_RegistrationForm_MemberGroup" aria-required="true">
							<li class="odd val4">
								<input id="Form_RegistrationForm_MemberGroup_4" class="radio" name="MemberGroup" type="radio" value="4" required="">
								<label for="Form_RegistrationForm_MemberGroup_4">... ein Koch und möchte einen passenden Job finden.</label>
							</li>
							<li class="even val5">
								<input id="Form_RegistrationForm_MemberGroup_5" class="radio" name="MemberGroup" type="radio" value="5" required="">
								<label for="Form_RegistrationForm_MemberGroup_5">... ein Arbeitgeber und suche passende Mitarbeiter/Innen</label>
							</li>
						</ul>
					</div>	
				</div>

				<% end_if %>

				<input type="hidden" name="SecurityID" value="e3aa7cf35d0d7e30f849eb9ff3b4862dfca7cf7a" class="hidden" id="Form_RegistrationForm_SecurityID">
			
			<div class="clear"><!-- --></div>
		</fieldset>

	
		<div class="Actions">
			<button type="submit" name="action_CreateEmployer" value="Kostenlos registrieren" class="action" id="Form_RegistrationForm_action_CreateEmployer">
				Kostenlos registrieren
			</button>
		</div>
	</form>

--%>

    </div>
  </div>
</section>