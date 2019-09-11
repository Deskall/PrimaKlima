

<div id="$HolderID" class="uk-clearfix field<% if $extraClass %> $extraClass<% end_if %> uk-margin-small">
	<label class="uk-form-label" for="$ID">
		<small><%t UndefinedOffset\\NoCaptcha\\Forms\\NocaptchaField.GoogleTerms 'Diese Seite ist durch reCAPTCHA geschützt und unterliegt <a href="https://policies.google.com/privacy" target="_blank" rel="nofollow">der Datenschutzerklärung</a> und <a href="https://policies.google.com/terms" target="_blank" rel="nofollow">den Nutzungsbedingungen</a> von Google.' %>
		</small>
	</label>
	<div class="uk-form-controls"><div class="g-recaptcha" id="Nocaptcha-$ID" data-sitekey="$SiteKey" data-theme="$CaptchaTheme.ATT" data-type="$CaptchaType.ATT" data-size="$CaptchaSize.ATT" data-form="$FormID" data-badge="$CaptchaBadge.ATT"></div>
	<noscript>
	    <p><%t UndefinedOffset\\NoCaptcha\\Forms\\NocaptchaField.NOSCRIPT "Sie müssen JavaScript aktivieren, um dieses Formular abschicken zu können" %></p>
	</noscript>
</div>

