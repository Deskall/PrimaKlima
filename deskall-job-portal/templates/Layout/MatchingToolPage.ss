
	$ElementalArea
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<% if Results %>
			<div data-uk-grid>
				<div class="uk-width-1-3@s uk-with-1-4@m uk-width-1-5@l uk-width-1-6@l">
					<div data-uk-sticky="offset:100">
						<h3>Filter</h3>
					</div>
				</div>
				<div class="uk-width-2-3@s uk-with-3-4@m uk-width-4-5@l uk-width-5-6@l">
					<h2>Matching Tool - Ergebnisse</h2>
					<div id="results">$Results</div>
				</div>
			</div>
			<% else %>
			<h2>Matching Tool - Suche nach Kompatibilität</h2>
			$MatchingToolForm
			<% end_if %>
		</div>
	</section>



