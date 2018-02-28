<% if $Controller.data.hasCaptcha %>
 <div id='recaptcha' class="g-recaptcha"
          data-sitekey="6LchV0kUAAAAAO933jAsFfyjanFlxT2nbRd1s5Tc"
          data-callback="onSubmit"
          data-size="invisible"></div>
<% end_if %>
<% if $Actions %>
<nav class="Actions uk-navbar uk-margin">
	<div class="uk-navbar-right">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
</nav>
<% end_if %>
