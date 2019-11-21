<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-visible@m">
				<% include ProductSidebar %>
			</div>
			<div class="uk-hidden@m uk-margin">
				<div class="uk-child-width-1-2 uk-flex uk-flex-center uk-flex-middle uk-grid-match" data-uk-grid>
					<% loop activeCategories %>
					<div>
						<div class="uk-card uk-card-body uk-card-default uk-padding-small">
						    <a href="$Link" title="$Title"><div class="uk-text-center">$MenuTitle</div></a>
						</div>
					</div>
					<% end_loop %>
				</div>
			</div>
			<div class="uk-width-3-4@m">
				
				<div>
					<a href="$MainShopPage.Link" title="$MainShopPage.Title">$MainShopPage.MenuTitle</a> » $Category.BreadCrumbs
				</div>
				<% with Category %>
				<h1>$Title</h1>
				<div class="uk-child-width-1-1 uk-child-width-1-2@l" data-uk-grid>
					<% if activeProducts.exists %>
					<% loop activeProducts %>
					<div>
				        <% include ProductCard %>
					</div>
					<% end_loop %>
					<% else %>
					<div><p><%t Product.NoProduct 'Es gibt keine Produkte in dieser Kategorie' %></p></div>
					<% end_if %>
				</div>
				
				<% end_with %>

			</div>
		</div>
	</div>
</section>