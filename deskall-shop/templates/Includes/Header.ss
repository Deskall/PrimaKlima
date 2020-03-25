<header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			<div class="uk-navbar-center">
				<div class="uk-navbar-center-left"><div><% with SiteConfig.activeMenuBlocks.filter('Class','main-left') %>$forTemplate<% end_with %></div></div>
		        <a href="" class="uk-navbar-item uk-logo"><% with SiteConfig.activeMenuBlocks.filter('type','logo') %>$forTemplate<% end_with %></a>
		        <div class="uk-navbar-center-right"><div><% with SiteConfig.activeMenuBlocks.filter('Class','main-right') %>$forTemplate<% end_with %></div></div>
			</div>
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
</header>