<div class="elemental-preview">
     
        <div class="elemental-preview__detail">
		    <% if Type == "content" %>
		    $Content.Summary(20)
		    <% else_if Type == "logo" %>
		    <img src="$Logo.URL" width="150" />
            <% else_if Type == "divider" %>
            <hr style="width:100px;">
            <% else_if Type == "social" %>
            <ul style="padding-left:0;">
                <% if SiteConfig.Facebook %>
                <li style="display:inline-block;"><a href="$SiteConfig.Facebook" data-uk-icon="facebook" target="_blank">facebook</a></li>
                <% end_if %>
                <% if SiteConfig.Twitter %>
                <li style="display:inline-block;"><a href="$SiteConfig.Twitter" data-uk-icon="twitter" target="_blank">twitter</a></li>
                <% end_if %>
                 <% if SiteConfig.Linkedin %>
                <li style="display:inline-block;"><a href="$SiteConfig.Linkedin" data-uk-icon="linkedin" target="_blank">linkedin</a></li>
                <% end_if %>
                <% if SiteConfig.Xing %>
                <li style="display:inline-block;"><a href="$SiteConfig.Xing" data-uk-icon="xing" target="_blank">xing</a></li>
                <% end_if %>
            </ul>
            <% else_if Type == "address" %>
            <h3>$SiteConfig.AddressTitle</h3>
            <ul>
                
                    <li>
                        $SiteConfig.Address<br/>
                        $SiteConfig.CodeCity<br/>
                        $SiteConfig.Country
                    </li>
                    <% if SiteConfig.Email %>
                    <li>
                        $SiteConfig.Email
                    </li>
                    <% end_if %>
                    <% if SiteConfig.Phone %>
                    <li>
                        $SiteConfig.Phone
                    </li>
                    <% end_if %>
                    <% if SiteConfig.Mobile %>
                    <li>
                        $SiteConfig.Mobile
                    </li>
                    <% end_if %>
                </ul>
        	<% else_if Type == "links" %>
        		<% if UseMenu %>
        			<% loop Menu.limit(2) %>
        		    	<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
        		    		<% if ShowSubLevels && Children %>
        		    		<div class="uk-navbar-dropdown uk-margin-remove">
        	                    <ul class="uk-nav uk-navbar-dropdown-nav">
        	                    	<% loop Children.limit(2) %>
        	                    	  <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
        	                    	<% end_loop %>
        	                    </ul>
        	                </div>
        	                <% end_if %>
        	            </li>
        		    <% end_loop %>
                    <% if Menu.count > 2 %>
                    <li>...</li>
                    <% end_if %>
        		 <% end_if %>
                <% loop $activeLinks.limit(2) %>
                        $forTemplate
                <% end_loop %>
                <% if activeLinks.count > 2 %>
                    <li>...</li>
                <% end_if %>
            <% end_if %>
        </div>
</div>
