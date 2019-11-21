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
				<div class="uk-child-width-1-1 uk-child-width-1-2@l" data-uk-grid>
					<% loop activeProducts %>
					<div>
				        <% include ProductCard %>
					</div>
					<% end_loop %>
				</div>
			</div>
		</div>
	</div>
</section>
