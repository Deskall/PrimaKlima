<header class="dk-background-header uk-position-top uk-position-z-index">
	<div class="uk-container uk-container-medium uk-position-relative">
		<a href="" class="uk-logo uk-align-left uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom"><img src="$ThemeDir/img/logo.png" alt="$SiteConfig.Title Logo" title="Home" /></a>
		<nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
			<div class="uk-navbar-right uk-visible@m">
			    <ul class="uk-subnav uk-padding-small uk-margin-remove">
			    	<% loop Menu(1).filter('ShowInMainMenu',0) %>
			    	<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			    		<% if Children %>
			    		<div class="uk-navbar-dropdown uk-margin-remove">
		                    <ul class="uk-nav uk-navbar-dropdown-nav">
		                    	<% loop Children %>
		                    	  <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
		                    	<% end_loop %>
		                    </ul>
		                </div>
		                <% end_if %>
		            </li>
			    	<% end_loop %>
			    </ul>
			</div>
		</nav>
		<nav class="uk-navbar-container uk-navbar-transparent uk-navbar" uk-navbar>
			
			<div class="uk-navbar-right uk-visible@m">
			    <ul class="uk-navbar-nav">
			    	<% loop Menu(1).filter('ShowInMainMenu',1) %>
			    	<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			    		<% if Children %>
			    		<div class="uk-navbar-dropdown uk-margin-remove">
		                    <ul class="uk-nav uk-navbar-dropdown-nav">
		                    	<% loop Children %>
		                    	  <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
		                    	<% end_loop %>
		                    </ul>
		                </div>
		                <% end_if %>
		            </li>
			    	<% end_loop %>
			    </ul>
			</div>
			<div class="uk-navbar-right uk-hidden@m">
	            <button class="uk-button uk-padding" type="button" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-flip"></button>
	        </div>
		</nav>
		
	</div>
</header>