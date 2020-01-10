<header <% if $SiteConfig.StickyHeader %>class="dk-background-header $ExtraHeaderClass" data-uk-sticky="sel-target: .uk-navbar-container;" <% else %>class="dk-background-header <% if SiteConfig.BackContent %>uk-position-top uk-position-z-index<% end_if %> $ExtraHeaderClass"<% end_if %>>
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
	<div class="uk-background-muted uk-padding-small">
		<div class="uk-container">
			<form class="finder-bar uk-flex uk-flex-around uk-flex-middle" data-uk-grid>

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
							<input list="places" name="place" class="uk-input" placeholder="<%t FinderBar.Position 'Ort' %>">
							<datalist id="places">
								<% loop $Portal.groupedBy(City) %>
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
</header>

