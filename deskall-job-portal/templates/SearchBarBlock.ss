<form class="finder-bar uk-flex uk-flex-around uk-flex-middle">
				<strong><%t FinderBar.SearchTitle 'Suche' %>:</strong>
				

				<div class="select-holder inline">
					<input list="positions" name="position" class="uk-input" placeholder="<%t FinderBar.Position 'Beruf,Position' %>">
					<datalist id="positions">
						<% loop $getPositions %>
							<option value="$Title">$Title</option>
						<% end_loop %>
					</datalist>
				</div>



				<div class="select-holder inline">
					<input list="places" name="place" class="uk-input" placeholder="<%t FinderBar.Position 'Ort' %>">
					<datalist id="places">
						<% loop $getCities.groupedBy(City) %>
							<option value="$City" <% if $Selected %>selected<% end_if %>>$City</option>
						<% end_loop %>
					</datalist>
				</div>

				<button class="uk-button uk-button-primary uk-flex uk-flex-middle"><span><%t FinderBar.SearchAction 'Suchen' %></span><i class="icon icon-chevron-right uk-margin-small uk-text-small"></i></button>
			</form>