
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
							        <% include MatchCard %>
							    </div>
							    <% end_loop %>
							<% else %>
							<p><%t MatchingTool.noResults 'Es gibt keine Ergebnisse.' %></p>
						    <% end_if %>
						</div>
					</div>
				</div>
			</div>
			<% include MatchModal %>
			<% else %>
			<h2>Matching Tool - Suche nach Kompatibilität</h2>
			$MatchingToolExplanation
			$MatchingToolForm
			<% end_if %>
		</div>
	</section>


