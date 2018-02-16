<footer class="uk-section" uk-height-match="target:h3;row:false;">
	<div class="uk-container">
		<div class="uk-padding-small uk-padding-remove-left uk-padding-remove-top">
		<img src="$ThemeDir/img/logo.png" />
	</div>
		<div class="uk-panel uk-flex uk-flex-left@s uk-flex-around@m uk-margin-small-top" uk-grid>
			<div class="uk-width-1-3">
			 	<h3>$SiteConfig.AddressTitle</h3>
			 	<ul class="uk-list uk-list-large dk-list">
			 		<li uk-icon="icon: location;">
			 			$SiteConfig.Address<br/>
			 			$SiteConfig.CodeCity<br/>
			 			$SiteConfig.Country
			 		</li>
			 		<li uk-icon="icon: mail;">
			 			$SiteConfig.Email
			 		</li>
			 		<li uk-icon="icon: phone;">
			 			$SiteConfig.Phone
			 		</li>
		        </ul>
		    </div>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width">
		    	<h3>$Title</h3>
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