<header <% if $SiteConfig.StickyHeader %>class="dk-background-header" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header uk-position-top uk-position-z-index"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<%-- <a href="" class="uk-logo uk-align-left" title="$SiteConfig.Title Home"><img src="$ThemeDir/img/logo.svg" alt="$SiteConfig.Title Logo" title="Home" data-uk-svg /></a> --%>
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			
			<% loop SiteConfig.activeMenuBlocks %>
				$forTemplate
			<% end_loop %>

			<% include LocaleMenu %>
		
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
</header>