<header <% if $SiteConfig.StickyHeader %>class="dk-background-header" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if $hover %>uk-position-top uk-position-z-index<% end_if %>"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			
			<% loop SiteConfig.activeMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
</header>