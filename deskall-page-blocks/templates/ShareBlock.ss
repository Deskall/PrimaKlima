
<div class="uk-panel">
	<div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	<div class="social-container">
		<% if $ShowFacebook %>
		<a class="uk-icon-button uk-margin-right" data-uk-icon="facebook" href="https://www.facebook.com/sharer/sharer.php?u={$Parent.getOwnerPage.Link.URLATT}" target="_blank"></a>
		<% end_if %>
		<% if $ShowTwitter %>
	    <a class="uk-icon-button uk-margin-right" data-uk-icon="twitter" href="https://twitter.com/intent/tweet?url={$Parent.getOwnerPage.Link.URLATT}" target="_blank"></a>
	  	<% end_if %>
		<% if $ShowGoogle %>
	    <a class="uk-icon-button uk-margin-right" data-uk-icon="google" href="https://plus.google.com/share?url={$Parent.getOwnerPage.Link.URLATT}" target="_blank"></a>
	  	<% end_if %>
	  	<% if $ShowPinterest %>
		 	<a class="uk-icon-button uk-margin-right" data-uk-icon="pinterest" href="http://pinterest.com/pin/create/button/?url={$Parent.getOwnerPage.Link.URLATT}&media={$BaseHref}{}&description={$Parent.getOwnerPage.Title}" class="pin-it-button pinterest" count-layout="horizontal" target="_blank"></a>
		<% end_if %>
		<% if $ShowLinkedin %>
		 	<a class="uk-icon-button uk-margin-right" data-uk-icon="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url={$Parent.getOwnerPage.Link.URLATT}&title={$Parent.getOwnerPage.Title.URLATT}&source={$SiteConfig.Title.URLATT}" class="pin-it-button pinterest" count-layout="horizontal" target="_blank"></a>
		<% end_if %>
		<% if $ShowXing %>
		 	<a class="uk-icon-button uk-margin-right" data-uk-icon="xing" href="http://pinterest.com/pin/create/button/?url={$Parent.getOwnerPage.Link.URLATT}&media={$BaseHref}{}&description={$Parent.getOwnerPage.Title}" class="pin-it-button pinterest" count-layout="horizontal" target="_blank"></a>
		<% end_if %>
	</div>
</div>

