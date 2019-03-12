<header class="dk-background-header $ExtraHeaderClass uk-height-1-1">
			

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

   <% if SiteConfig.HeaderBackgroundImage.exists %>
	</div>
   <% end_if %>
</header>