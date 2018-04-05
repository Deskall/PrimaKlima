<div class="$Layout $Width uk-visible@m">
	<% if Type == "links" %>
	<ul class="uk-navbar-nav">
		<% if UseMenu %>
		<% loop Menu(1) %>
		<% end_loop %>
		<% loop $activeLinks %>
			$forTemplate
		<% end_loop %>
	</ul>		  
	<% end_if %>
	<% if Type == "logo" %>
	  <a href="/" class="uk-navbar-item uk-logo"><img src="$Logo.URL" alt="$SiteConfig.Title Logo" title="Home" /></a>
	<% end_if %>
</div>