<% include TextBlock %>
<div data-uk-filter="target: .reference-box">
	<ul>
		<% loop Categories %>
		<li uk-filter-control="filter:.{$URLSegment}"><a>$Title</a></li>
		<% end_loop %>
	</ul>
<div class="uk-child-width-auto uk-grid-small" data-uk-grid="masonry:true;" data-uk-scrollspy="target:.reference-box;cls:uk-animation-fade;delay:100;">
	<% loop activeReferences %>
	<div class="reference-box uk-flex uk-flex-center uk-flex-middle <% loop PortfolioCategories %>.{$URLSegment}<% end_loop %>">
		$Logo.FitMax(150,150)
	</div>
	<% end_loop %>
</div>
</div>