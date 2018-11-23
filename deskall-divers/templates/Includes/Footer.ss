<footer class="uk-section" data-uk-height-match="target:.title-container;row:false;">
	<div class="uk-container">
		<div class="uk-panel uk-flex uk-flex-left@s uk-margin-small-top" data-uk-grid>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width $Layout $Class">
		    	<% if Type == "address" %>
		    	<div class="title-container">
			 		<h3 class="uk-margin-small-bottom">$SiteConfig.AddressTitle</h3>
			 	</div>

			 	<ul class="uk-list uk-list-large dk-list uk-margin-remove-top">$SiteConfig.Address
			 		<% if $SiteConfig.Address != "" || $SiteConfig.CodeCity != "" %>
			 		<li><a href="https://www.google.com/maps/place/{$SiteConfig.Address.URLATT},{$SiteConfig.CodeCity.URLATT}, {$SiteConfig.Country.URLATT}/" target="_blank" title="$SiteConfig.Title">
			 			<span class="uk-margin-small-right" data-uk-icon="icon: location;"></span>
			 			<span class="dk-link-with-icon">
			 				<% if $SiteConfig.Address %>
				 			$SiteConfig.Address<br/>
				 			<% end_if %>
				 			<% if $SiteConfig.CodeCity %>
				 			$SiteConfig.CodeCity<br/>
				 			<% end_if %>
				 			<% if $SiteConfig.Country %>
				 			$SiteConfig.Country
				 			<% end_if %>
				 		</span>
				 		</a>
			 		</li>
			 		<% end_if %>
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
		    			<% if $Logo.getExtension == "svg" %>
		    			<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo" data-uk-svg />
		    			<% else %>
		    			<img src="$Logo.ScaleMaxWidth($Top.SiteConfig.IntVal($Top.SiteConfig.FooterLogoWidth)).URL" alt="$Top.SiteConfig.Title Logo" />
		    			<% end_if %>
		    		</a>
		    	</div>
		    	<% else_if Type == "partners" %>
		    	<div>
		    		<% if Title %>
		    		 <div class="title-container">
			    		<h3 class="uk-margin-small-bottom">$Title</h3>
			    	</div>
			    	<% end_if %>
		    		<div class="uk-child-width-1-3 uk-flex uk-flex-middle" data-uk-grid>
		    			<% loop Partners.Sort('SortOrder') %>
		    			<div class="uk-text-center partner-container">
		    			<% if $getExtension == "svg" %>
		    			<img src="$URL" alt="$AltTag($Title)" class="svg-logo format-{$Orientation} <% if $Height > 100 %>restrict-height<%end_if %>" />
		    			<% else %>
		    			<img src="$FitMax(200,100).URL" />
		    			<% end_if %>
		    			</div>
		    			<% end_loop %>
		    		</div>
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