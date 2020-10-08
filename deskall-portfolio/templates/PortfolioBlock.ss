<% include TextBlock %>
<div data-uk-filter="target: .js-filter">
	<ul>
		<% loop Categories %>
		<li uk-filter-control="[data-tags*='{$URLSegment}']"><a>$Title</a></li>
		<% end_loop %>
	</ul>
	<div class="js-filter uk-child-width-auto uk-grid-small" data-uk-grid="masonry:true;" data-uk-scrollspy="target:.reference-box;cls:uk-animation-fade;delay:100;">
		<% loop activeReferences %>
		<div data-tags="<% loop PortfolioCategories %>{$URLSegment} <% end_loop %>">
			<div class="reference-box uk-flex uk-flex-center uk-flex-middle">
				$Logo.FitMax(150,150)
			</div>
		</div>
		<% end_loop %>
	</div>
</div>