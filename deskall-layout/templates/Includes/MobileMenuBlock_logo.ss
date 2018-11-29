<div class="$Layout $Class">
	<a href="/" class="uk-navbar-item uk-logo">
		<% if $Logo.getExtension == "svg" %>
		<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo"  />
		<% else %>
		<img src="$Logo.ScaleHeight($Top.SiteConfig.IntVal($Top.SiteConfig.HeaderLogoHeight)).URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"/>
		<% end_if %>
	</a>
</div>