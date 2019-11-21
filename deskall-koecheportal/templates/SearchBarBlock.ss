<form class="finder-bar uk-flex uk-flex-around uk-padding-small">
				<strong><%t FinderBar.SearchTitle 'Suche' %>:</strong>
				

				<div class="select-holder inline">
					<select data-chosen-filter name="position" class="uk-select" data-placeholder="<%t FinderBar.Position 'Position' %>">
						<option value="" data-empty-value></option>
						<% loop $getPositions.Sort('Title') %>
							<% if $Title %>
							<option value="$Value" <% if $Selected %>selected<% end_if %>>$Title</option>
							<% end_if %>
						<% end_loop %>
					</select>
				</div>



				<div class="select-holder inline">
					<select data-chosen-filter class="uk-select" name="postal" data-placeholder="<%t FinderBar.Place 'Ort' %>">
						<option value="" data-empty-value></option>
						<% loop $getPostals.Sort('Title') %>
							<% if $Title %>
							<option value="$Value" <% if $Selected %>selected<% end_if %>>$Title</option>
							<% end_if %>
						<% end_loop %>
					</select>
				</div>


<%--

				<div data-dropdown class="inline dropdown">
					<a data-dropdown-toggle class="toggle"><%t FinderBar.Position 'Position' %><span data-value-name="position" data-value="" data-value-title="" class="value-holder"></span></a>
					<ul class="content">


						<% loop $getPositions.Sort('Title') %>
							<li data-dropdown-value="$Value">$Title</li>
						<% end_loop %>

					</ul>
				</div>




				<div data-dropdown class="inline dropdown">
					<a data-dropdown-toggle class="toggle"><%t FinderBar.Place 'Wo' %><span data-value-name="postal" data-value="" data-value-title="" class="value-holder" ></span></a>
					<ul class="content">

						<% loop $getPostals.Sort('Title') %>
							<% if $Title %>
							<li data-dropdown-value="$Value">$Title</li>
							<% end_if %>
						<% end_loop %>

					</ul>
				</div>
--%>



				<button data-search-ads class="uk-button PrimaryBackground"><%t FinderBar.SearchAction 'Suchen' %><i class="icon icon-chevron-right uk-margin-small"></i></button>
			</form>