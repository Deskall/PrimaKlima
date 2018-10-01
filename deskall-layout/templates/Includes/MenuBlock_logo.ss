<div class="$Layout <% if Type != "logo" %><% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %><% end_if %> $Class">
	<a href="/" class="uk-navbar-item uk-logo">
		<% if $Logo.getExtension == "svg" %>
		<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo" data-uk-svg />
		<% else %>
		<img src="$Logo.ScaleWidth(150).URL" data-srcset="$Logo.ScaleWidth(150).URL 150w, $Logo.ScaleWidth(250).URL 250w, $Logo.ScaleWidth(350).URL 350w" data-sizes="150w, (min-width:650px) 250w, (min-width:1200px) 350w" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"  data-uk-img/>
		<% end_if %>
	</a>
</div>