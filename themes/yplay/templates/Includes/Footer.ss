<footer class="uk-section" data-uk-height-match="target:.title-container;row:false;">
	<div class="uk-container">
		<div class="uk-panel uk-flex uk-flex-left@s uk-margin-small-top uk-margin-large-bottom" data-uk-grid>
			<% loop $SiteConfig.activeFooterBlocks.exclude('Class','nav-secondary') %>
		    <div class="$Width $Layout $Class">
		    	<% if Type == "address" %>
			    	<div class="title-container">
				 		<h3 class="uk-margin-small-bottom">$SiteConfig.AddressTitle</h3>
				 	</div>

				 	<ul class="uk-list uk-list-large dk-list dk-list-with-icon uk-margin-remove-top">
				 		<% if $SiteConfig.Address != "" %>
				 		<li><span data-uk-icon="icon: location;"></span>
				 			<a href="https://www.google.com/maps/place/{$SiteConfig.Address.URLATT},{$SiteConfig.Code.URLATT}+{$SiteConfig.City.URLATT},+{$SiteConfig.Country.URLATT}/" target="_blank" title="$SiteConfig.Title" rel="nofollow">
				 				<% if $SiteConfig.Address %>
					 			$SiteConfig.Address<br/>
					 			<% end_if %>
					 			<% if $SiteConfig.Code %>
					 			$SiteConfig.Code - $SiteConfig.City<br/>
					 			<% end_if %>
					 			<% if $SiteConfig.Country %>
					 			$SiteConfig.Country
					 			<% end_if %>
					 		</a>
				 		</li>
				 		<% end_if %>
				 		<% if SiteConfig.Email %>
				 		<li>
				 			<span data-uk-icon="icon: mail;"></span>
				 			<a href="mailTo:{$SiteConfig.Email}" title="<%t SiteConfig.EmailTitleTag 'Email zu' %> $SiteConfig.Title" target="_blank" rel="noopener noreferrer">
				 				$SiteConfig.Email
				 			</a>
				 		</li>
				 		<% end_if %>
				 		<% if SiteConfig.Phone %>
				 		<li>
				 			<span data-uk-icon="icon: receiver;"></span>
				 			$SiteConfig.Phone
				 		</li>
				 		<% end_if %>
				 		<% if SiteConfig.Mobile %>
				 		<li>
				 			<span data-uk-icon="icon: phone;"></span>
					 		$SiteConfig.Mobile
				 		</li>
				 		<% end_if %>
				 		<% if SiteConfig.Fax %>
				 		<li>
				 			<span data-uk-icon="icon: print;"></span>
					 		$SiteConfig.Fax
				 		</li>
				 		<% end_if %>
				 		<% if SiteConfig.Notfall %>
				 		<li>
				 			<span data-uk-icon="icon: bell;"></span>
					 		$SiteConfig.Notfall
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
			    			<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" class="svg-logo" width="$Top.SiteConfig.FooterLogoWidth" />
			    			<% else %>
			    			<img src="$Logo.ScaleMaxWidth($Top.SiteConfig.IntVal($Top.SiteConfig.FooterLogoWidth)).URL" alt="$Top.SiteConfig.Title Logo" />
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
	<div class="uk-margin-small-top dk-footer-secondary">
		<div class="uk-container">
		<% if SiteConfig.Facebook || SiteConfig.Twitter || SiteConfig.Linkedin || SiteConfig.Xing || SiteConfig.Instagramm %>
		<nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
			<div class="uk-navbar-center uk-padding uk-padding-remove-horizontal">
				<ul class="uk-iconnav uk-flex uk-flex-around">
					<% if SiteConfig.Facebook %>
					<li><a href="$SiteConfig.Facebook" target="_blank" data-uk-icon="facebook" rel="nofollow"></a></li>
					<% end_if %>
					<% if SiteConfig.Twitter %>
					<li><a href="$SiteConfig.Twitter" target="_blank" data-uk-icon="twitter" rel="nofollow"></a></li>
					<% end_if %>
					<% if SiteConfig.Linkedin %>
					<li><a href="$SiteConfig.Linkedin" target="_blank" data-uk-icon="linkedin" rel="nofollow"></a></li>
					<% end_if %>
					<% if SiteConfig.Xing %>
					<li><a href="$SiteConfig.Xing" target="_blank" data-uk-icon="xing" rel="nofollow"></a></li>
					<% end_if %>
					<% if SiteConfig.Instagram %>
					<li><a href="$SiteConfig.Instagram" target="_blank" data-uk-icon="instagram" rel="nofollow"></a></li>
					<% end_if %>
				</ul>
			</div>
		</nav>
		<% end_if %>
		<% loop $SiteConfig.activeFooterBlocks.filter('Class','nav-secondary') %>
			<nav class="uk-navbar-container uk-navbar-transparent uk-margin-bottom" data-uk-navbar>
			    <div class="uk-navbar-center">
			        <div class="uk-navbar-nav uk-flex uk-flex-middle uk-flex-center uk-flex-wrap">
			            <% loop $activeLinks %>
			           		<div>
			           			<% with LinkableLink %>
			           			    <% if $LinkURL %>
			           			     	<a  href="$LinkURL" {$TargetAttr} <% if Rel %>rel="$Rel"<% end_if %> class="<% if $Background %>uk-button button-{$Background}<% end_if %> <% if hasIcone %>dk-link-with-icon<% end_if %>">
			           		                <% if hasIcone %>
			           		                <% if $Icone %><span class="uk-margin-small-right" data-uk-icon="icon:  $Icone;"></span><% end_if %> 
			           			            <span class="dk-link-with-icon-text">$Title</span>
			           		                <% else %>
			           		                $Title
			           		                <% end_if %>
			           			        </a>
			           			    <% end_if %>
			           			<% end_with %>
			           		</div>
			           	<% end_loop %>
			        </div>
			    </div>
			</nav>
			<% end_loop %>
			<div class="copyright">
				© $Now.Year YplaY, GIB-Solutions AG
			</div>
		</div>
	</div>
</footer>