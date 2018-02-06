<footer >
		<div class="container">
			<div class="col w-12 logo-container">
        		<a href="/"><img class="footer-logo" src="$ThemeDir/img/logo.svg" alt="$SiteConfig.AddressTitle, $SiteConfig.AddressCity"/></a>
      		</div>
			<% loop $SiteConfig.Blocks.Sort('SortOrder') %>
			<div class="col w-$Width $Class">
				<h3>$Title</h3>
				<% loop $Links.Sort('SortOrder') %>
					$forTemplate
				<% end_loop %>
			</div>
			<% end_loop %>
		</div>
</footer>


