<header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<div class="uk-grid-collapse uk-flex uk-flex-middle uk-flex-right" data-uk-grid>
			
			<div class="uk-width-4-5">
				<nav class="uk-navbar-container uk-navbar-transparent uk-visible@m uk-navbar-sub" data-uk-navbar>
				
							<% if $ID > 0 %>
							<div class="uk-navbar-right">
								<ul class="uk-navbar-nav sub">
									<li><a id="toggle-modal-postal-code" data-uk-tooltip="<%t PLZ.CHANGE 'Region ändern' %>" data-active="<% if activePLZ %>true<% else %>false<% end_if %>" data-trigger="<% if showModalPLZ %>true<% else %>false<% end_if %>" title="Ihrer PLZ auswählen / Ändern" data-uk-toggle="#modal-postal-code"><% if activePLZ %>Ihre Region: $activePLZ.CodeCity<% else %> Region unbekannt<% end_if %></a><br>
										Ihre Technologie: $activeOffer
									</li>
									<% if activePLZ %>
									<li>
										<a href="{$Link}plz-loeschen" title="Region löschen" data-uk-tooltip="<%t PLZ.CLEAR 'Region löschen' %>"><i class="icon icon-close-circled"></i></a>
									</li>
									<% end_if %>
								</ul>
							</div>
							<% end_if %>
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
							<div class="uk-navbar-right">
								<ul class="uk-navbar-nav">
									<li class="link"><a href="#" data-uk-toggle="#modal-search"><i class="uk-margin-small-right"  data-uk-icon="search"></i><small>Suchen</small></a></li>
									<li class="link"><a href="https://mein.yplay.ch/" target="_blank"><i class="uk-margin-small-right" data-uk-icon="user"></i><small>Mein Konto</small></a></li>
									<li class="link"><a href="#" data-uk-toggle="#modal-notifications"><i class="uk-margin-small-right"  data-uk-icon="bell"><span class="uk-label uk-label-danger uk-border-rounded" >2</span></i><small>Meldungen</small></a></li>
									<%-- <li class="link"><a href="#"><i class="fab fa-opencart uk-text-large uk-margin-small-right"></i><small>1 Meldung(s) im Warenkorb</small></a></li> --%>
								</ul>
							</div>
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
								<ul class="uk-navbar-nav mobile-icon-nav">
									<li class="link"><a href="#" data-uk-toggle="#modal-search" data-uk-icon="search"></a></li>
									<li class="link"><a href="https://mein.yplay.ch/" data-uk-icon="user" target="_blank"></a></li>
									<li class="link"><a href="#" data-uk-toggle="#modal-notifications" data-uk-icon="bell" ><span class="uk-label uk-label-danger uk-border-rounded" >2</span></a></li>
									<%-- <li class="link"><a href="#"><i class="fab fa-opencart uk-text-large uk-margin-small-right"></i><small>1 Meldung(s) im Warenkorb</small></a></li> --%>
			
			            			<li class="link"><a class="dk-toggle-mobile-menu" data-uk-navbar-toggle-icon data-uk-toggle="#modal-nav-mobile"></a></li>
			            		</ul>
			        </div>
			        
				</nav>
				
		
				
	</div>
	<div class="uk-navbar-dropbar"></div>

	<div id="modal-nav-mobile" class="uk-modal-full dk-nav-mobile-container" data-uk-modal>
	    <div class="uk-modal-dialog">
	         <button class="uk-modal-close-full uk-close-large" type="button" data-uk-close></button>
           <% loop SiteConfig.activeMobileMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			<div class="copyright uk-text-center uk-margin-top">
				© $Now.Year flashcable, GIB-Solutions AG
			</div>
	    </div>
	</div>

	<div id="modal-search" class="uk-modal-full dk-nav-mobile-container" data-uk-modal>
	    <div class="uk-modal-dialog" data-uk-height-viewport>
	        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
	       	<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" data-uk-grid>
        		
	        	<div class="uk-padding-large">
		        	<h2>Suche</h2>
			        <form class="search-form uk-flex uk-flex-between" method="GET" action="{$Link}SearchForm">
			        	<input type="text" class="uk-input" minlength="4" required name="Search" placeholder="<%t Search.PLACEHOLDER 'Suche auf dieser Website...' %>" />
			        	<button type="submit"><i data-uk-icon="search"></i></button>
			        </form>
			    </div>
			    <div class="uk-background-cover uk-visible@m" style="background-image:url('$ThemeDir/img/paul-green-mln2ExJIkfc-unsplash.jpg');" data-uk-height-viewport></div>
		    </div>
	    </div>
	</div>

	<div id="modal-notifications" class="uk-modal-full dk-nav-mobile-container" data-uk-modal>
	    <div class="uk-modal-dialog" data-uk-height-viewport>
	        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        	<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" data-uk-grid>
        		<div class="uk-background-cover uk-visible@m" style="background-image:url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');" data-uk-height-viewport></div>
	        	<div class="uk-padding-large">
	        		<h2>Meldungen</h2>
			        <ul data-uk-accordion>
			            <li>
			                <a class="uk-accordion-title" href="#">Meldung 1</a>
			                <div class="uk-accordion-content">
			                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			                </div>
			            </li>
			            <li>
			                <a class="uk-accordion-title" href="#">Meldung 2</a>
			                <div class="uk-accordion-content">
			                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
			                </div>
			            </li>
			        </ul>
			    </div>
	    	</div>
	    </div>
	</div>
</header>