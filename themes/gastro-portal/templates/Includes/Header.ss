<header <% if $SiteConfig.StickyHeader %>class="uk-box-shadow-medium dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="uk-box-shadow-mediul dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="header-top uk-padding-small">
		<div class="uk-container uk-container-medium uk-position-relative">
			<% if ClassName == "HomePage" %>
				<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
					<% loop SiteConfig.activeMenuBlocks.filter('type','logo') %>
						$forTemplate
					<% end_loop %>	
					<% loop SiteConfig.activeMenuBlocks.filter('class','dk-nav-top') %>
						$forTemplate
					<% end_loop %>
					<div class="uk-navbar-right uk-hidden@l">
			            <button class="uk-button uk-flex uk-flex-middle uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
			        </div>
				</nav>
			<% else %>
			<div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
				<div class="uk-width-1-5@m">
					<div class="uk-text-center">
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
				<div class="uk-width-4-5 uk-visible@m">
					<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
						
						<% loop SiteConfig.activeMenuBlocks.filter('class','dk-nav-top') %>
							<% if Type == "Languages" %>
								<% include MenuBlock_Languages Locales=Top.Locales %>
							<% else %>
								$forTemplate
							<% end_if %>
						<% end_loop %>
					</nav>
					<% if ClassName != "HomePage" %>
					<div class="uk-margin-top">
					<% include SearchForm Link=$Link,Position=$Portal.getPositions,Cities=$Portal.getCities.groupedBy(City),Align=uk-flex-right %>
					</div>
					<% end_if %>
				</div>
			</div>
			<% end_if %>
		</div>
	</div>
<% if $ClassName == "HomePage" %>
<div class="uk-position-relative" tabindex="-1" data-uk-slideshow="min-height: 200; max-height: 600;autoplay:true;autoplayInterval:5000;animation:fade;">
    <ul class="uk-slideshow-items">
    	<% loop SiteConfig.activeSlides %>
        <li>
             <img src="$Image.FocusFill(320,250).URL" data-srcset="$Image.FocusFill(320,250).URL 320w, $Image.FocusFill(650,500).URL 650w, $Image.FocusFill(1200,800).URL 1200w, $Image.FocusFillMax(2500,1500).URL 2500w" alt="" data-uk-cover data-uk-img>
             <div class="dk-slide-text-container dk-overlay $Background uk-height-1-1 ">
                    <div class="uk-container uk-height-1-1 <% if $Top.FullWidth %>uk-container-expand<% end_if %>">
                        <div class="uk-position-relative uk-height-1-1">
                            <div class="dk-slide-text $TextPosition $TextBackground $TextWidth $TextOffset <% if TextOpacity %>uk-overlay<% end_if %> <% if TextBackground != "no-bg" %>uk-padding-small<% end_if %>">
                                <% if Effect == "parallax" %> <div data-uk-slideshow-parallax="$EffectOptions"><% end_if %>
                                <h2 class="$TitleAlign uk-h1">$SiteConfig.Tagline</h2>
                                <div class="uk-text-lead $TextAlign  $TextColumns">$Content</div>
                                <% if Effect == "parallax" %></div><% end_if %>
                                <% if LinkableLinkID > 0 %>
                                    <% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
                                <% end_if %>
                            </div>
                        </div>
                    </div>
                </div>
        </li>
        <% end_loop %>
    </ul>
</div>
<% end_if %>
<div class="uk-container uk-container-medium uk-position-relative">
	<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
		
		<% loop SiteConfig.activeMenuBlocks.filter('class','dk-nav-main') %>
			$forTemplate
		<% end_loop %>
		<div class="uk-navbar-right uk-hidden@l">
            <button class="uk-button uk-flex uk-flex-middle uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
        </div>
	</nav>
			
</div>
</header>