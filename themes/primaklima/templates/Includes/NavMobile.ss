<div id="offcanvas-flip" uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar uk-width-1-1">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <ul class="uk-nav-default dk-nav-mobile uk-nav-parent-icon" uk-nav>
            	<li class="uk-nav-header">$SiteConfig.Title</li>
            	<% loop Menu(1) %>
			        <li class="$LinkingMode <% if $Children %>uk-parent<% end_if %> <% if LinkingMode == "current" %>uk-active<% end_if %>">
			            <a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			            <% if $Children %>
			            <ul class="uk-nav-sub">
			            	<% loop $Children %>
			                <li class="$LinkingMode <% if LinkingMode == "current" %>uk-active<% end_if %>" >
			                	<a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			                </li>
			                <% end_loop %>
			            </ul>
			            <% end_if %>
			        </li>
			    <% end_loop %>
			    <li class="uk-nav-divider"></li>
			    <li><a href="">TO DO : Social </a></li>
			</ul>

        </div>
    </div>