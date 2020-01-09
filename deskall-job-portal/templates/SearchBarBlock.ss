<form class="finder-bar uk-flex uk-flex-around uk-flex-middle">
				<strong><%t FinderBar.SearchTitle 'Suche' %>:</strong>
				

				<div class="select-holder inline">
					<input list="positions" name="position" class="uk-input" data-placeholder="<%t FinderBar.Position 'Position' %>">
					<datalist id="positions">
						<% loop $getPositions %>
							<option value="$Title">$Title</option>
						<% end_loop %>
					</datalist>
				</div>



				<div class="select-holder inline">
					<input list="places" name="place" class="uk-input" data-placeholder="<%t FinderBar.Position 'Position' %>">
					<datalist id="places">
						<% loop $getCities %>
							<option value="$value" <% if $Selected %>selected<% end_if %>>$value</option>
						<% end_loop %>
					</datalist>
				</div>

				<button data-search-ads class="uk-button PrimaryBackground"><%t FinderBar.SearchAction 'Suchen' %><i class="icon icon-chevron-right uk-margin-small"></i></button>
			</form>