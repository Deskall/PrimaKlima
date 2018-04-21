<div id="offcanvas-flip" data-uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar uk-width-1-1 dk-nav-mobile-container $SiteConfig.MobileNaviBackground">

            <button class="uk-offcanvas-close" type="button" data-uk-close></button>

           <% loop SiteConfig.activeMobileMenuBlocks %>
				$forTemplate
			<% end_loop %>
			

        </div>

    </div>