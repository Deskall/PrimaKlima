<header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			<div class="uk-navbar-center">
				<% loop SiteConfig.activeMenuBlocks %>
					<% if Type == 'form' %>
						<div class="$Layout $Width uk-visible@m $Class">$Top.SearchForm</div>
					<% else_if Type == "Languages" %>
						<% include MenuBlock_Languages Locales=Top.Locales %>
					<% else_if Type == "Logo" %>
						<a href="/" class="uk-navbar-item uk-logo">
							<% if $Logo.getExtension == "svg" %>
							<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo"  />
							<% else %>
								<% if $Top.SiteConfig.HeaderLogoHeight > 0 %>
								<img src="$Logo.ScaleHeight($Top.SiteConfig.IntVal($Top.SiteConfig.HeaderLogoHeight)).URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"/>
								<% else %>
								<img src="$Logo.ScaleHeight(80).URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"/>
								<% end_if %>
							<% end_if %>
						</a>
					<% else %>
						$forTemplate
					<% end_if %>
				<% end_loop %>
			</div>
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
</header>