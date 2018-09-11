<footer class="uk-section" data-uk-height-match="target:.title-container;row:false;">
	<div class="uk-container">
		<div class="uk-panel uk-flex uk-flex-left@s uk-margin-small-top" data-uk-grid>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width $Layout $Class">
		    	<% if Type == "address" %>
		    	<div class="title-container">
			 		<h3 class="uk-margin-small-bottom">$SiteConfig.AddressTitle</h3>
			 	</div>
			 	<ul class="uk-list uk-list-large dk-list uk-margin-remove-top">
			 		<li><a href="https://www.google.com/maps/place/{$SiteConfig.Address.URLATT},{$SiteConfig.CodeCity.URLATT}, {$SiteConfig.Country.URLATT}/" target="_blank" title="$SiteConfig.Title">
			 			<span class="uk-margin-small-right" data-uk-icon="icon: location;"></span>
			 			<span class="dk-link-with-icon">
				 			$SiteConfig.Address<br/>
				 			$SiteConfig.CodeCity<br/>
				 			$SiteConfig.Country
				 		</span>
				 		</a>
			 		</li>
			 		<% if SiteConfig.Email %>
			 		<li>
			 			<a href="mailTo:{$SiteConfig.Email}" title="<%t SiteConfig.EmailTitleTag 'Email zu' %> $SiteConfig.Title">
			 				<span class="uk-margin-small-right" data-uk-icon="icon: mail;"></span>
			 				<span class="dk-link-with-icon">$SiteConfig.Email</span>
			 			</a>
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Phone %>
			 		<li>
			 			
			 				<span class="uk-margin-small-right" data-uk-icon="icon: receiver;"></span>
			 				<span class="dk-link-with-icon">$SiteConfig.Phone</span>
			 			
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Mobile %>
			 		<li>
			 			
			 				<span class="uk-margin-small-right"  data-uk-icon="icon: phone;"></span>
				 			<span class="dk-link-with-icon">$SiteConfig.Mobile</span>
				 		
			 		</li>
			 		<% end_if %>
		        </ul>
		        <% else_if Type == "content" %>
		        <div class="title-container">
		    		<h3 class="uk-margin-small-bottom">$Title</h3>
		    	</div>
		    	$Content
		    	<% else_if Type == "logo" %>
		    	<div>
		    		<a href="/" class="uk-navbar-item uk-logo">
		    			<% if $Image.getExtension == "svg" %>
		    			<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" />
		    			<% else %>
		    			<img src="$Logo.ScaleWidth(150).URL" data-srcset="$Logo.ScaleWidth(150).URL 150w, $Logo.ScaleWidth(250).URL 250w, $Logo.ScaleWidth(350).URL 350w" sizes="150w, (min-width:650px) 250w, (min-width:1200px) 350w" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" />
		    			<% end_if %>
		    		</a>
		    	</div>
		        <% else %>
		    	<div class="title-container">
		    		<h3 class="uk-margin-small-bottom">$Title</h3>
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