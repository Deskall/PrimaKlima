<form class="finder-bar uk-flex uk-flex-around uk-flex-middle" data-uk-grid>

				<div class="uk-width-2-5">
					<strong><i class="icon icon-people"></i><%t FinderBar.PositionLabel 'Was?' %></strong>
					<input list="positions" name="position" class="uk-input" placeholder="<%t FinderBar.Position 'Beruf,Position' %>">
					<datalist id="positions">
						<% loop $getPositions %>
							<option value="$Title">$Title</option>
						<% end_loop %>
					</datalist>
				</div>



				<div class="uk-width-2-5">
					<strong><i class="icon icon-location"></i><%t FinderBar.PlaceLabel 'Wo?' %></strong>
					<input list="places" name="place" class="uk-input" placeholder="<%t FinderBar.Position 'Ort' %>">
					<datalist id="places">
						<% loop $getCities.groupedBy(City) %>
							<option value="$City" <% if $Selected %>selected<% end_if %>>$City</option>
						<% end_loop %>
					</datalist>
				</div>
				<div class="uk-width-1-5">
					<button class="uk-button uk-button-secondary uk-flex uk-flex-middle"><span><%t FinderBar.SearchAction 'Jobs suchen' %></span><i class="icon icon-chevron-right uk-margin-small-left uk-text-small"></i></button>
				</div>
			</form>