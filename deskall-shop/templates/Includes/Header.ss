<header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent subnav" data-uk-navbar>
		<% loop SiteConfig.activeMenuBlocks.filter('Class','dk-nav-top') %>$forTemplate<% end_loop %>
		</nav>
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			
			
			
			<%-- <div class="uk-navbar-center">
				<div class="uk-navbar-center-left">
					<div> --%>
					<% with SiteConfig.activeMenuBlocks.filter('Class','main').first %>
					<div class="uk-navbar-left <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class uk-flex-bottom">
						<ul class="uk-navbar-nav <% if UseMenu %>$UseMenuOption<% end_if %>">
							<% if UseMenu %>
							<% loop Menu.limit(2) %>
							<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
								<% if Up.ShowSubLevels && Children %>
								<div class="uk-navbar-dropdown">
									<ul class="uk-nav uk-navbar-dropdown-nav">
										<% loop Children %>
										<li class="uk-position-relative $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML<% if Top.ShowSubLevels && Children %><div id="link-{$ID}" class="uk-position-center-right uk-position-small"><i class="fa fa-chevron-right uk-margin-small-left"></i></div><% end_if %></a>
											<% if Top.ShowSubLevels && Children %>
											<div class="second" data-uk-dropdown="pos:right-top">
												<ul class="uk-nav uk-dropdown-nav">
													<% loop Children %>
													<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
													</li>
													<% end_loop %>
												</ul>
											</div>
											<% end_if %>
										</li>
										<% end_loop %>
									</ul>
								</div>
								<% end_if %>
							</li>
							<% end_loop %>
							<% end_if %>
							</ul>
						</div>		  
						<% end_with %>
					
		        	<% with SiteConfig.activeMenuBlocks.filter('type','logo').first %>
			        	<a href="/" class="uk-navbar-item uk-logo">
			        			<% if Logo.exists %>
			        				<% if $Logo.getExtension == "svg" %>
			        				<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo"  />
			        				<% else %>
			        					<% if $Top.SiteConfig.HeaderLogoHeight > 0 %>
			        					<img src="$Logo.ScaleHeight($Top.SiteConfig.IntVal($Top.SiteConfig.HeaderLogoHeight)).URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"/>
			        					<% else %>
			        					<img src="$Logo.ScaleHeight(80).URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"/>
			        					<% end_if %>
			        				<% end_if %>
			        			<% end_if %>
			        		</a>
		        	<% end_with %>
		        
		        <%-- <div class="uk-navbar-center-right">
		        	<div> --%>
						<% with SiteConfig.activeMenuBlocks.filter('Class','main').first %>
						<div class="uk-navbar-right <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class uk-flex-bottom">
							<ul class="uk-navbar-nav <% if UseMenu %>$UseMenuOption<% end_if %>">
								<% if UseMenu %>
								<% loop Menu %>
								<% if Pos == 3 || Pos == 4 %>
								<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
									<% if Up.ShowSubLevels && Children %>
									<div class="uk-navbar-dropdown">
										<ul class="uk-nav uk-navbar-dropdown-nav">
											<% loop Children %>
											<li class="uk-position-relative $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML<% if Top.ShowSubLevels && Children %><div id="link-{$ID}" class="uk-position-center-right uk-position-small"><i class="fa fa-chevron-right uk-margin-small-left"></i></div><% end_if %></a>
												<% if Top.ShowSubLevels && Children %>
												<div class="second" data-uk-dropdown="pos:right-top">
													<ul class="uk-nav uk-dropdown-nav">
														<% loop Children %>
														<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
														</li>
														<% end_loop %>
													</ul>
												</div>
												<% end_if %>
											</li>
											<% end_loop %>
										</ul>
									</div>
									<% end_if %>
								</li>
								<% end_if %>
								<% end_loop %>
								<% end_if %>
							</ul>	
						</div>	  
						<% end_with %>
				<%-- 	</div>
		        </div> --%>
			
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
</header>