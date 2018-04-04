<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
     
        <div class="elemental-preview__detail">
        	<% if Type == "adresse" %>
        	<ul class="uk-list uk-list-large dk-list uk-margin-remove-top">
			 		<li data-uk-icon="icon: location;">
			 			$SiteConfig.Address<br/>
			 			$SiteConfig.CodeCity<br/>
			 			$SiteConfig.Country
			 		</li>
			 		<% if SiteConfig.Email %>
			 		<li data-uk-icon="icon: mail;">
			 			$SiteConfig.Email
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Phone %>
			 		<li data-uk-icon="icon: receiver;">
			 			$SiteConfig.Phone
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Mobile %>
			 		<li data-uk-icon="icon: receiver;">
			 			$SiteConfig.Mobile
			 		</li>
			 		<% end_if %>
		        </ul>
		    <% else_if Type == "content" %>
		    $Content
        	<% else %>
            <h3><% if Title %>$Title <% end_if %></h3>
                 <% loop $activeLinks %>
                        $forTemplate
                    <% end_loop %>
            <% end_if %>
        </div>
    </a>
</div>
