<footer class="uk-section" uk-height-match="target:.title-container;row:false;">
	<div class="uk-container">
		<div class="uk-padding-small uk-padding-remove-left uk-padding-remove-top">
		<img src="$ThemeDir/img/logo.png" />
	</div>
		<div class="uk-panel uk-flex uk-flex-left@s uk-flex-around@m uk-margin-small-top" uk-grid>
			<div class="uk-width-1-1@s uk-width-1-3@m">
			 	<div class="title-container uk-position-relative">
			 		<h3 class="uk-position-bottom uk-margin-remove">$SiteConfig.AddressTitle</h3>
			 	</div>
			 	<ul class="uk-list uk-list-large dk-list">
			 		<li uk-icon="icon: location;">
			 			$SiteConfig.Address<br/>
			 			$SiteConfig.CodeCity<br/>
			 			$SiteConfig.Country
			 		</li>
			 		<% if SiteConfig.Email %>
			 		<li uk-icon="icon: mail;">
			 			$SiteConfig.Email
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Phone %>
			 		<li uk-icon="icon: receiver;">
			 			$SiteConfig.Phone
			 		</li>
			 		<% end_if %>
			 		<% if SiteConfig.Mobile %>
			 		<li uk-icon="icon: receiver;">
			 			$SiteConfig.Mobile
			 		</li>
			 		<% end_if %>
		        </ul>
		    </div>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width">
		    	<div class="title-container uk-position-relative">
		    		<h3 class="uk-position-bottom uk-margin-remove">$Title</h3>
		    	</div>
		    	<ul class="uk-list uk-list-large dk-list">
				    <% loop $activeLinks %>
						<% include FooterLink %>
					<% end_loop %>
				</ul>
		    </div>
		   <% end_loop %>
		</div>
	</div>
</footer>