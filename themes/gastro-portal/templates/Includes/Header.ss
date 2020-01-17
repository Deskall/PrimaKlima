<%-- <header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
	<div class="uk-container uk-container-medium uk-position-relative">
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			
			<% loop SiteConfig.activeMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@l $Class">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			<div class="uk-navbar-right uk-hidden@l">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
				
	</div>
	<% if ClassName != "HomePage" %>
	<div class="header-slider uk-position-relative">
			<div data-uk-slideshow="autoplay: true;animation: fade;autoplay-interval:5000;min-height: 300; max-height:300">
			    <ul class="uk-slideshow-items">
			    	<% loop SiteConfig.activeSlides %>
			        <li>
			        	<div class="uk-inline uk-width-1-1 uk-height-1-1">
						    <img src="$Image.ScaleWidth(320).URL" data-srcset="$Image.ScaleWidth(320).URL 320w, $Image.ScaleWidth(650).URL 650w, $Image.ScaleWidth(1200).URL 1200w, $Image.ScaleWidth(1500).URL 2500w" alt="" data-uk-cover data-sizes="100vw" data-uk-img>
						    <div class="uk-overlay uk-position-bottom-right uk-text-right">
						    	<div class="header-slide-title">$Title</div>
			            		<div class="header-slide-subtitle">$Content</div>
			            	</div>
						</div>
			        </li>
			        <% end_loop %>
			    </ul>
			</div>
	</div>
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
	<% end_if %>
</header> --%>

<div class="header-slider uk-position-relative">
	
		<div data-uk-slideshow="autoplay: true;animation: fade;autoplay-interval:5000;min-height: 300; max-height:300">
		    <ul class="uk-slideshow-items">
		    	<% loop SiteConfig.activeSlides %>
		        <li>
		        	<div class="uk-inline uk-width-1-1 uk-height-1-1">
					   <img src="$Image.ScaleWidth(320).URL" data-srcset="$Image.ScaleWidth(320).URL 320w, $Image.ScaleWidth(650).URL 650w, $Image.ScaleWidth(1200).URL 1200w, $Image.ScaleWidth(1500).URL 2500w" alt="" data-uk-cover data-sizes="100vw" data-uk-img>
					    <div class="uk-overlay uk-position-bottom-right uk-text-right">
					    	<div class="header-slide-title">$Title</div>
		            		<div class="header-slide-subtitle">$Content</div>
		            	</div>
					</div>
		        </li>
		        <% end_loop %>
		    </ul>
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
		<div class="header-slider-logo uk-position-center">
			<a href="/" title="home"><img src="$ThemeDir/img/logo.svg" class="header-logo" /></a>
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
</header>