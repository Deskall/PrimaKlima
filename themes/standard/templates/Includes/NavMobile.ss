<div id="offcanvas-flip" data-uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar uk-width-1-1 dk-nav-mobile-container">

            <button class="uk-offcanvas-close" type="button" data-uk-close></button>
           <div class="uk-margin-top">
           <% loop SiteConfig.activeMobileMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			<form class="search-form uk-flex uk-flex-between" method="GET" action="suchen/SearchForm">
							<input list="search-suggestions" autocomplete="off" type="text" class="uk-input" minlength="3" required name="Search" placeholder="<%t Search.PLACEHOLDER 'Suche auf dieser Website...' %>" />
							<datalist id="search-suggestions">
							    <% loop Suggestions %>
							    <option value="$Title">
							    <% end_loop %>
							</datalist>
							<button type="submit"><i data-uk-icon="search"></i></button>
						</form>
			</div>
        </div>

    </div>