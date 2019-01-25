<header>
	<div data-uk-sticky>
		<div class="uk-padding-small">
			<% loop SiteConfig.activeMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</div>
	</div>
</header>