
	$ElementalArea
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<% if Matches %>
			<div data-uk-grid>
				<div class="uk-width-1-2@s uk-width-1-3@m">
					<div data-uk-sticky="offset:100">
						<div class="uk-background-muted">
							<h3>Filter</h3>
						</div>
					</div>
				</div>
				<div class="uk-width-1-2@s uk-width-2-3@m">
					<h2>Matching Tool - Ergebnisse</h2>
					<div id="results">
						<div class="uk-grid-small uk-child-width-expand@s uk-text-center" data-uk-grid>
						    <div>
						        <div class="uk-card uk-card-default uk-card-body">Item</div>
						    </div>
						    <div>
						        <div class="uk-card uk-card-default uk-card-body">Item</div>
						    </div>
						    <div>
						        <div class="uk-card uk-card-default uk-card-body">Item</div>
						    </div>
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



