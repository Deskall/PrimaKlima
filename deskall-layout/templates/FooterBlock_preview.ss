<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
     
        <div class="elemental-preview__detail">
        	<% if Type == "address" %>
        	<h3>$SiteConfig.AddressTitle</h3>
        	<ul>
        		
			 		<li>
			 			$SiteConfig.Address<br/>
			 			$SiteConfig.Code - $SiteConfig.City<br/>
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
		    <% else_if Type == "content" %>
		    <h3><% if Title %>$Title <% end_if %></h3>
		    $Content
		    <% else_if Type == "logo" %>
		    <img src="$Logo.URL" width="150" />
        	<% else %>
            <h3><% if Title %>$Title <% end_if %></h3>
                 <% loop $activeLinks %>
                        $forTemplate
                    <% end_loop %>
            <% end_if %>
        </div>
    </a>
</div>
