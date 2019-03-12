<header class="dk-background-header $ExtraHeaderClass uk-height-1-1 <% if $HeaderBackgroundImage.exists %>uk-cover-container dk-overlay with-background<% end_if %" 
	<% if $HeaderBackgroundImage.exists %>
		<% if $HeaderBackgroundImage.getExtension == "svg" %>data-src="$HeaderBackgroundImage.URL"
		<% else %>data-src="$HeaderBackgroundImage.ScaleWidth(1200).URL" data-uk-img
		<% end_if %>
	<% end_if %>>
				

    <ul class="uk-nav-default uk-nav-parent-icon uk-padding-small" data-uk-nav>
    	<% loop SiteConfig.activeMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
    </ul>

</header>