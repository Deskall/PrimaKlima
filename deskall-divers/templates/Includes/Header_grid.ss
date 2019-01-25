<header>
	<div data-uk-sticky>
		<div class="uk-padding-small">
			<% loop SiteConfig.activeMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"></button>
	        </div>
			<%-- <div class="dk-logo-container">
				<img src="$ThemeDir/img/logo.svg" />
			</div>
		    <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
		        <li class="uk-active"><a href="#">Active</a></li>
		        <li class="uk-parent">
		            <a href="#">Parent</a>
		            <ul class="uk-nav-sub">
		                <li><a href="#">Sub item</a></li>
		                <li>
		                    <a href="#">Sub item</a>
		                    <ul>
		                        <li><a href="#">Sub item</a></li>
		                        <li><a href="#">Sub item</a></li>
		                    </ul>
		                </li>
		            </ul>
		        </li>
		        <li class="uk-parent">
		            <a href="#">Parent</a>
		            <ul class="uk-nav-sub">
		                <li><a href="#">Sub item</a></li>
		                <li><a href="#">Sub item</a></li>
		            </ul>
		        </li>
		    </ul> --%>
		</div>
	</div>
</header>