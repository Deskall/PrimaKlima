<header class="dk-background-header uk-cover-container $ExtraHeaderClass uk-height-1-1">
			
	<img src="$SiteConfig.HeaderBackgroundImage.URL" data-uk-cover />
    <div class="uk-position-center">
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
   	 </div>

</header>