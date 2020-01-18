<% if Class == "HomePage" %>
<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="ratio: false">

    <ul class="uk-slideshow-items" uk-height-viewport="offset-top: true; offset-bottom: 30">
    	<% loop SiteConfig.activeSlides %>
        <li>
             <img src="$Image.FocusFill(320,250).URL" data-srcset="$Image.FocusFill(320,250).URL 320w, $Image.FocusFill(650,500).URL 650w, $Image.FocusFill(1200,800).URL 1200w, $Image.FocusFillMax(2500,1500).URL 2500w" alt="" data-uk-cover data-uk-img>
        </li>
        <% end_loop %>
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>

</div>
<% else %>
<header <% if $SiteConfig.StickyHeader %>class="uk-box-shadow-medium dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="uk-box-shadow-mediul dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	
	
	<div class="header-top uk-padding-small">
		<div class="uk-container">
			<div class="uk-grid-small uk-flex uk-flex-middle" data-uk-grid>
				<div class="uk-width-1-5">
					<div class="uk-text-center uk-margin-bottom">
						<% with SiteConfig.activeMenuBlocks.filter('type','Logo').first %>
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
					</div>
				</div>
				<div class="uk-width-4-5">
						<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
							
							<% loop SiteConfig.activeMenuBlocks.filter('class','dk-nav-top') %>
								<% if Type == "Languages" %>
									<% include MenuBlock_Languages Locales=Top.Locales %>
								<% else %>
									$forTemplate
								<% end_if %>
							<% end_loop %>
						</nav>
						
							<form method="GET" action="$OfferPage.Link" class="finder-bar uk-grid-small uk-flex uk-flex-right uk-flex-middle" data-uk-grid>

										<div class="uk-width-1-3 uk-flex uk-flex-left uk-flex-middle">
											<strong class="uk-margin-small-right"><%t FinderBar.PositionLabel 'Was?' %></strong>
											<input list="positions" name="position" class="uk-input" placeholder="<%t FinderBar.Position 'Beruf,Position' %>">
											<datalist id="positions">
												<% loop $Portal.getPositions %>
													<option value="$Title">$Title</option>
												<% end_loop %>
											</datalist>
										</div>



										<div class="uk-width-1-3 uk-flex uk-flex-left uk-flex-middle">
											<strong class="uk-margin-small-right"><%t FinderBar.PlaceLabel 'Wo?' %></strong>
											<input list="places" name="ort" class="uk-input" placeholder="<%t FinderBar.Place 'Ort' %>">
											<datalist id="places">
												<% loop $Portal.getCities.groupedBy(City) %>
													<option value="$City" <% if $Selected %>selected<% end_if %>>$City</option>
												<% end_loop %>
											</datalist>
										</div>
										<div class="uk-width-1-3">
											<button class="uk-button button-PrimaryBackground uk-flex uk-flex-middle"><span><%t FinderBar.SearchAction 'Jobs suchen' %></span><i class="icon icon-chevron-right uk-margin-small-left uk-text-small"></i></button>
										</div>
							</form>
						
				</div>
			</div>
		</div>
	</div>
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			
			<% loop SiteConfig.activeMenuBlocks.filter('class','dk-nav-main') %>
				$forTemplate
			<% end_loop %>
			<div class="uk-navbar-right uk-hidden@l">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
	
</header>
<% end_if %>
<%-- <div class="header-slider uk-position-relative">
		<div class="PrimaryBackground uk-padding-small">
			<div class="uk-container">
				<form method="GET" action="$OfferPage.Link" class="finder-bar uk-flex uk-flex-around uk-flex-middle" data-uk-grid>

							<div class="uk-width-2-5 uk-flex uk-flex-left uk-flex-middle">
								<strong class="uk-margin-small-right"><%t FinderBar.PositionLabel 'Was?' %></strong>
								<input list="positions" name="position" class="uk-input" placeholder="<%t FinderBar.Position 'Beruf,Position' %>">
								<datalist id="positions">
									<% loop $Portal.getPositions %>
										<option value="$Title">$Title</option>
									<% end_loop %>
								</datalist>
							</div>



							<div class="uk-width-2-5 uk-flex uk-flex-left uk-flex-middle">
								<strong class="uk-margin-small-right"><%t FinderBar.PlaceLabel 'Wo?' %></strong>
								<input list="places" name="ort" class="uk-input" placeholder="<%t FinderBar.Position 'Ort' %>">
								<datalist id="places">
									<% loop $Portal.getCities.groupedBy(City) %>
										<option value="$City" <% if $Selected %>selected<% end_if %>>$City</option>
									<% end_loop %>
								</datalist>
							</div>
							<div class="uk-width-1-5">
								<button class="uk-button button-SecondaryBackground uk-flex uk-flex-middle"><span><%t FinderBar.SearchAction 'Jobs suchen' %></span><i class="icon icon-chevron-right uk-margin-small-left uk-text-small"></i></button>
							</div>
				</form>
			</div>
		</div>
		<div class="uk-position-top">
			<div class="uk-container uk-container-medium">
				<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
					
					<% loop SiteConfig.activeMenuBlocks.filter('Class','dk-nav-top') %>
						$forTemplate
					<% end_loop %>
				</nav>
			</div>
		</div>
		<div class="header-logo uk-position-center">
			<a href="/" title="home" class="uk-logo"><img src="$ThemeDir/img/logo.svg"  /></a>
		</div>

		<div class="uk-position-center-right dk-service-links uk-visible@m">
	        <a data-share class="item share" ></a>

			<div class="service-share"  id="service-share">
				<a data-close-share class="close-share" ></a>
				<div class="shariff" data-button-style="icon" data-mail-url="mailto:$SiteConfig.Email" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;googleplus&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
			</div>
	    </div>

	
</div>
<header class="dk-background-header uk-width-1-1 uk-box-shadow-large" data-uk-sticky="sel-target: .uk-navbar-container;">
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			
			<% loop SiteConfig.activeMenuBlocks.exclude('Class','dk-nav-top') %>
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
</header> --%>