<div id="offcanvas-flip" data-uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar uk-width-1-1 dk-nav-mobile-container">

            <button class="uk-offcanvas-close" type="button" data-uk-close></button>
           <div class="uk-margin-top">
           <% loop SiteConfig.activeMobileMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			</div>
        </div>

    </div>