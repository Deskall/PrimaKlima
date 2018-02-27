<div id="offcanvas-flip" data-uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar uk-width-1-1">

            <button class="uk-offcanvas-close" type="button" data-uk-close></button>

            <ul class="uk-nav-default dk-nav-mobile uk-nav-parent-icon uk-margin-top" data-uk-nav>
        
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
			    <li class="uk-nav-divider uk-margin-small"></li>
			    <% if SiteConfig.Facebook %>
			    <li><a href="$SiteConfig.Facebook" data-uk-icon="facebook" target="_blank"></a></li>
			    <% end_if %>
			    <% if SiteConfig.Twitter %>
			    <li><a href="$SiteConfig.Twitter" data-uk-icon="twitter" target="_blank"></a></li>
			    <% end_if %>
			     <% if SiteConfig.Linkedin %>
			    <li><a href="$SiteConfig.Linkedin" data-uk-icon="linkedin" target="_blank"></a></li>
			    <% end_if %>
			    <% if SiteConfig.Xing %>
			    <li><a href="$SiteConfig.Xing" data-uk-icon="xing" target="_blank"></a></li>
			    <% end_if %>
			</ul>

			<div class="uk-width-1-1 uk-margin uk-text-muted dk-mobile-address">
			 	<div class="title-container">
			 		<strong>$SiteConfig.AddressTitle</strong>
			 	</div>
			 	<ul class="uk-list uk-nav-default dk-list">
			 		<li data-uk-icon="icon: location;ratio: 0.75;">
			 			$SiteConfig.Address<br/>
			 			$SiteConfig.CodeCity<br/>
			 			$SiteConfig.Country
			 		</li>
			 		<% if SiteConfig.Email %>
			 		<li data-uk-icon="icon: mail;ratio: 0.75;">
			 			$SiteConfig.Email
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Phone %>
			 		<li data-uk-icon="icon: receiver;ratio: 0.75;">
			 			$SiteConfig.Phone
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Mobile %>
			 		<li data-uk-icon="icon: phone;ratio: 0.75;">
			 			$SiteConfig.Mobile
			 		</li>
			 		<% end_if %>
		        </ul>
		    </div>

        </div>

    </div>