<footer class="uk-section-small">
	<div class="uk-container">
		<img src="$ThemeDir/img/logo.png" />
		<div class="uk-flex uk-flex-left@s uk-flex-around@m uk-margin-small-top" uk-grid>
			<% loop $SiteConfig.activeFooterBlocks %>
		    <div class="$Width">
		    	<h3>$Title</h3>
		    	<ul class="uk-list uk-list-large">
				    <% loop $activeLinks %>
						<% include FooterLink %>
					<% end_loop %>
				</ul>
		    </div>
		   <% end_loop %>
		</div>
	</div>
</footer>