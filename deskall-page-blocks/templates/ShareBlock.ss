
<div class="uk-panel">
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	
	<% if LinkableLinkID > 0 %>
		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	<% end_if %>
	<div class="social-container">
		<% if $ShowFacebook %>
		<a class="uk-icon-button uk-margin-right" data-uk-icon="facebook" href="https://www.facebook.com/sharer/sharer.php?u={$getPage.AbsoluteLink.URLATT}" target="_blank"></a>
		<% end_if %>
		<% if $ShowTwitter %>
	    <a class="uk-icon-button uk-margin-right" data-uk-icon="twitter" href="https://twitter.com/intent/tweet?url={$getPage.AbsoluteLink.URLATT}" target="_blank"></a>
	  	<% end_if %>
		
	  	<% if $ShowPinterest %>
		 	<a class="uk-icon-button uk-margin-right" data-uk-icon="pinterest" href="http://pinterest.com/pin/create/button/?url={$getPage.AbsoluteLink.URLATT}&media={$BaseHref}{}&description={$getPage.Title}" target="_blank"></a>
		<% end_if %>
		<% if $ShowLinkedin %>
		 	<a class="uk-icon-button uk-margin-right" data-uk-icon="linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url={$getPage.AbsoluteLink.URLATT}" target="_blank"></a>
		<% end_if %>
		<% if $ShowXing %>
		 	<a class="uk-icon-button uk-margin-right" data-uk-icon="xing" href="https://www.xing.com/spi/shares/new?url={$getPage.AbsoluteLink.URLATT}" target="_blank"></a>
		<% end_if %>
	</div>
</div>

