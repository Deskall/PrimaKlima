<% include TextBlock %>
<div data-uk-filter="target: .js-filter">
	<select>
		<% loop Categories %>
		<option data-uk-filter-control="[data-tags*='{$URLSegment}']"><a>$Title</a></option>
		<% end_loop %>
	</select>
	<div class="js-filter uk-child-width-auto uk-grid-small" data-uk-grid="masonry:true;">
		<% loop activeReferences %>
		<div data-tags="<% loop PortfolioCategories %>{$URLSegment} <% end_loop %>">
			<div class="reference-box uk-flex uk-flex-center uk-flex-middle">
				$Logo.FitMax(150,150)
			</div>
		</div>
		<% end_loop %>
	</div>
</div>