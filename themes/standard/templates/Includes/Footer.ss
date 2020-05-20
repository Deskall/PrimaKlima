<footer class="uk-section" data-uk-height-match="target:.title-container;row:false;">
	<div class="uk-container">
		<div class="uk-panel uk-flex uk-flex-left@s uk-margin-small-top" data-uk-grid>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width $Layout $Class">
		    	<% if Type == "address" %>
		    	<div class="title-container">
			 		<h3 class="uk-margin-small-bottom">$SiteConfig.AddressTitle</h3>
			 	</div>
			 	<% if $SiteConfig.Address != "" %>
			 	<div><a href="https://www.google.com/maps/place/{$SiteConfig.Address.URLATT},{$SiteConfig.Code.URLATT}+{$SiteConfig.City.URLATT},+{$SiteConfig.Country.URLATT}/" target="_blank" title="$SiteConfig.Title" rel="nofollow"><span data-uk-icon="icon: location;"></span>
			 				<% if $SiteConfig.Address %>
				 			$SiteConfig.Address,
				 			<% end_if %>
				 			<% if $SiteConfig.Code %>
				 			$SiteConfig.Code $SiteConfig.City,
				 			<% end_if %>
				 			<% if $SiteConfig.Country %>
				 			$SiteConfig.Country
				 			<% end_if %>
				 		</a>
				</div>
				<% end_if %>
				<div class="uk-flex uk-flex-left">
					<% if SiteConfig.Email %>
					<div><span data-uk-icon="icon: mail;"></span>
			 			<a href="mailTo:{$SiteConfig.Email}" title="<%t SiteConfig.EmailTitleTag 'Email zu' %> $SiteConfig.Title" target="_blank" rel="noopener noreferrer">
			 				$SiteConfig.Email
			 			</a>
			 		</div>
			 		<% end_if %>
			 		<% if SiteConfig.Phone %>
			 		<div>
				 		<span data-uk-icon="icon: receiver;"></span>
				 		$SiteConfig.Phone
				 	</div>
			 		<% end_if %>
				</div>
		        <% else_if Type == "content" %>
		        <div class="title-container">
		    		<h3 class="uk-margin-small-bottom">$Title</h3>
		    	</div>
		    	$Content
		    	<% else_if Type == "logo" %>
		    	<div>
		    		<a href="/" class="uk-navbar-item uk-logo">
		    		<% if Logo.exists %>
		    			<% if $Logo.getExtension == "svg" %>
		    			<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo" width="$Top.SiteConfig.FooterLogoWidth" />
		    			<% else %>
		    			<img src="$Logo.ScaleMaxWidth($Top.SiteConfig.IntVal($Top.SiteConfig.FooterLogoWidth)).URL" alt="$Top.SiteConfig.Title Logo" />
		    			<% end_if %>
		    		<% end_if %>
		    		</a>
		    	</div>
		    	<% else_if Type == "items" %>
		    	<div>
		    		<% if Title %>
		    		 <div class="title-container">
			    		<h3 class="uk-margin-small-bottom">$Title</h3>
			    	</div>
			    	<% end_if %>
		    			<% loop Items %>
		    			<div class="uk-margin">
		    			<% if LinkableLinkID > 0 %>
		    			     <a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr}>
		    			 <% end_if %>
		    			    <div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-3@s uk-child-width-1-1@m" data-uk-grid >
		    			    
		    			     	<% if Image %>
				    			    <div>
				    			    	<% if Image.getExtension == "svg" %>
				    						<img src="$Image.URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" width="120">
				    					<% else %>
				    						<% if Image.ScaleWidth(120).Height > 100 %>
				    						<img src="$Image.ScaleHeight(100).URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" >
				    						<% else %>
				    						<img src="$Image.ScaleWidth(120).URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" >
				    						<% end_if %>
				    					<% end_if %> 
				    			    </div>
			    			    <% end_if %>
			    			    <div>
			    				    <div  class="$TitleAlign">$Title</div>
			    				    <div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			    				    	$Content
			    				    </div>
			    				 </div>
		    			   </div>
		    			<% if LinkableLinkID > 0 %>
			    			</a>
			    		<% end_if %>
			    	</div>
		    			<% end_loop %>
		    	</div>
		        <% else %>
		    	<div class="title-container">
		    		<h3 class="uk-margin-small-bottom">$Title</h3>
		    	</div>
		    	<ul class="uk-list dk-list uk-margin-remove-top">
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