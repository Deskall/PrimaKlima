<footer class="uk-section $SiteConfig.FooterBackground" data-uk-height-match="target:.title-container;row:false;">
	<div class="uk-container">
		<div class="uk-panel uk-flex uk-flex-left@s uk-margin-small-top" data-uk-grid>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width $Class">
		    	<% if Type == "adresse" %>
		    	<div class="title-container">
			 		<h3 class="uk-margin-small-bottom uk-margin-medium-top">$SiteConfig.AddressTitle</h3>
			 	</div>
			 	<ul class="uk-list uk-list-large dk-list uk-margin-remove-top">
			 		<li data-uk-icon="icon: location;"><a>
			 			$SiteConfig.Address<br/>
			 			$SiteConfig.CodeCity<br/>
			 			$SiteConfig.Country</a>
			 		</li>
			 		<% if SiteConfig.Email %>
			 		<li data-uk-icon="icon: mail;">
			 			<a>$SiteConfig.Email</a>
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Phone %>
			 		<li data-uk-icon="icon: receiver;">
			 			<a>$SiteConfig.Phone</a>
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Mobile %>
			 		<li data-uk-icon="icon: phone;">
			 			<a>$SiteConfig.Mobile</a>
			 		</li>
			 		<% end_if %>
		        </ul>
		        <% else_if Type == "content" %>
		        <div class="title-container">
		    		<h3 class="uk-margin-small-bottom uk-margin-medium-top">$Title</h3>
		    	</div>
		    	$Content
		    	<% else_if Type == "logo" %>
		    	<a href="/" class="uk-navbar-item uk-logo"><img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="Home" /></a>
		        <% else %>
		    	<div class="title-container">
		    		<h3 class="uk-margin-small-bottom uk-margin-medium-top">$Title</h3>
		    	</div>
		    	<ul class="uk-list uk-list-large dk-list uk-margin-remove-top">
				    <% loop $activeLinks %>
						$forTemplate
					<% end_loop %>
				</ul>
				<% end_if %>
		    </div>
		   <% end_loop %>
		</div>
	</div>
</footer>