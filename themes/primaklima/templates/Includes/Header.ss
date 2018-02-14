<header class="dk-background-header">
	<div class="uk-container uk-container-medium">
		<nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
			<div class="uk-navbar-right uk-visible@m">
			    <ul class="uk-subnav uk-padding-small uk-margin-remove">
			    	<% loop Menu(1).filter('ShowInMainMenu',0) %>
			    	<li class="$LinkingMode <% if LinkingMode == "current" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			    		<% if Children %>
			    		<div class="uk-navbar-dropdown uk-margin-remove">
		                    <ul class="uk-nav uk-navbar-dropdown-nav">
		                    	<% loop Children %>
		                    	  <li class="$LinkingMode <% if Current %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
		                    	<% end_loop %>
		                    </ul>
		                </div>
		                <% end_if %>
		            </li>
			    	<% end_loop %>
			    </ul>
			</div>
		</nav>
		<nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
			<div class="uk-navbar-left">
				<a href="" class="uk-navbar-item uk-logo"><img src="$ThemeDir/img/logo.png" alt="$SiteConfig.Title Logo" title="Home" /></a>
			</div>
			<div class="uk-navbar-right uk-visible@m">
			    <ul class="uk-navbar-nav">
			    	<% loop Menu(1).filter('ShowInMainMenu',1) %>
			    	<li class="$LinkingMode <% if LinkingMode == "current" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			    		<% if Children %>
			    		<div class="uk-navbar-dropdown uk-margin-remove">
		                    <ul class="uk-nav uk-navbar-dropdown-nav">
		                    	<% loop Children %>
		                    	  <li class="$LinkingMode <% if Current %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
		                    	<% end_loop %>
		                    </ul>
		                </div>
		                <% end_if %>
		            </li>
			    	<% end_loop %>
			    </ul>
			</div>
		</nav>
	</div>
</header>