
	$ElementalArea
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<% if activeQuery %>
			<div data-uk-grid>
				<%-- <div class="uk-width-1-2@s uk-width-1-3@m">
					<div data-uk-sticky="offset:100">
						<div class="">
							<h3>Filter</h3>
						</div>
					</div>
				</div>
				<div class="uk-width-1-2@s uk-width-2-3@m"> --%>
				<div class="uk-width-1-1">
					<h2>Matching Tool - Ergebnisse</h2>
					<div id="results">
						<div class="uk-grid-small uk-child-width-1-2@m" data-uk-grid="masonry:true">
							<% if activeQuery.Results %>
								<% loop activeQuery.Results %>
							    <div>
							        <div class="uk-card uk-card-default uk-card-body">
							        	<div class="uk-grid-small" data-uk-grid>
							        		<div class="uk-position-top-right"><span class="<% if Compatibility > 70 %>uk-label-success<% else_if Compatibility > 50 %>uk-label-warning<% else %>uk-label-danger<% end_if %> uk-padding-small">{$Compatibility}%</span>
							        		</div>
							        		<% if isVisible %>
								        		<% with Candidat %>
								        		<div class="uk-width-1-3">
								        			<img src="$Picture.URL" />
								        		</div>
								        		<div class="uk-width-1-3">
								        			<table>
								        				<tr><td>Name</td><td>$Member.FirstName $Member.Surname</td></tr>
								        				<tr><td>Ort</td><td>$Member.City</td></tr>
								        				<tr><td>Email</td><td>$Member.Email</td></tr>
								        				<tr><td>Telefon</td><td>$Phone</td></tr>
								        			</table>
								        		</div>
								        		<% end_with %>
							        		<% else %>
							        		<div class="uk-width-1-3">
							        			<img src="https://via.placeholder.com/150x200" />
							        		</div>
							        		<div class="uk-width-1-3">
							        			<table>
							        				<tr><td>Name</td><td>XXXX</td></tr>
							        				<tr><td>Ort</td><td>XXXX</td></tr>
							        				<tr><td>Email</td><td>XXXX</td></tr>
							        				<tr><td>Telefon</td><td>XXXX</td></tr>
							        			</table>
							        		</div>
							        		<% end_if %>
							        		$Description
							        		<div class="uk-text-center">
							        			<a class="uk-button uk-button-primary">Jetzt Kontakt erhalten</a>
							        		</div>
							        	</div>
							        </div>
							    </div>
							    <% end_loop %>
							<% else %>
							<p><%t MatchingTool.noResults 'Es gibt keine Ergebnisse.' %></p>
						    <% end_if %>
						</div>
					</div>
				</div>
			</div>
			<% else %>
			<h2>Matching Tool - Suche nach Kompatibilität</h2>
			$MatchingToolExplanation
			$MatchingToolForm
			<% end_if %>
		</div>
	</section>



