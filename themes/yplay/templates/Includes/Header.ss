<header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<div class="uk-grid-collapse uk-flex uk-flex-middle uk-flex-right" data-uk-grid>
			
			<div class="uk-width-4-5">
				<nav class="uk-navbar-container uk-navbar-transparent uk-visible@m uk-navbar-sub" data-uk-navbar>
					<%-- <div class="dk-nav-top-container uk-width-1-1 uk-visible@m">
						<div class="uk-grid-small" data-uk-grid>
							<div class="uk-width-1-3"> --%>
					<%-- 		<div class="uk-navbar-right">
								<form class="search-form" method="GET" action="{$Link}SearchForm">
									<input type="text" class="uk-input uk-width-medium" minlength="4" required name="Search" placeholder="<%t Search.PLACEHOLDER 'Suche auf dieser Website...' %>" />
									<button type="submit"><i class="fas fa-search"></i></button>
								</form>
							</div> --%>
							<%-- </div>
							<div class="uk-width-2-3"> --%>
							<div class="uk-navbar-right">
								<% loop SiteConfig.activeMenuBlocks.filter('Class','dk-nav-top') %>
									<ul class="uk-navbar-nav <% if UseMenu %>$UseMenuOption<% end_if %>">
										<% if UseMenu %>
										<% loop Menu %>
										<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
										</li>
										<% end_loop %>
										<% end_if %>
										<% loop $activeLinks %>
											$forTemplate
										<% end_loop %>
									</ul>		  
								<% end_loop %>
							</div>
							<div class="uk-navbar-right uk-visible@m">
								<ul class="uk-navbar-nav">
									<li class="link"><a href="#"><i class="fas fa-search uk-margin-small-right"></i><small>Suchen</small></a></li>
									<li class="link"><a href="#"><i class="fa fa-user uk-margin-small-right"></i><small>Mein Konto</small></a></li>
									<li class="link"><a href="#"><i class="fa fa-bell uk-margin-small-right"></i><small>Meldungen</small></a></li>
									<%-- <li class="link"><a href="#"><i class="fab fa-opencart uk-text-large uk-margin-small-right"></i><small>1 Item(s) im Warenkorb</small></a></li> --%>
								</ul>
							</div>
						<%-- 	</div>
						</div>
					</div> --%>
				</nav>
			</div>
		</div>

				<nav class="uk-navbar-container uk-navbar-transparent uk-navbar-main" data-uk-navbar="dropbar: true;boundary-align:true;mode:click;">

					<% with SiteConfig.activeMenuBlocks.filter('Type','logo').first %>
					$forTemplate
					<% end_with %>
					
					<% loop SiteConfig.activeMenuBlocks.filter('Class','dk-nav-main') %>
							<% include MainNaviDropdown %>
					<% end_loop %>
					
					<div class="uk-navbar-right uk-hidden@m">
			            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon></button>
			        </div>
			        
				</nav>
				
		
				
	</div>
	<div class="uk-navbar-dropbar"></div>
	<div data-uk-dropdown="toggle:.dk-toggle-mobile-menu;">
	    <ul class="uk-nav uk-dropdown-nav">
	        <li class="uk-active"><a href="#">Active</a></li>
	        <li><a href="#">Item</a></li>
	        <li class="uk-nav-header">Header</li>
	        <li><a href="#">Item</a></li>
	        <li><a href="#">Item</a></li>
	        <li class="uk-nav-divider"></li>
	        <li><a href="#">Item</a></li>
	    </ul>
	</div>
</header>

<% include NavMobile %>