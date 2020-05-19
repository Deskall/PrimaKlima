<div class="uk-container">
	<div data-uk-grid>
		<div class="uk-width-1-3@m uk-width-1-4@l uk-visible@m">
		</div>
		<div class="uk-width-1-1 uk-width-2-3@m uk-width-3-4@l">
			$ElementalArea
			
			<% if $ID < 0 %> 
				<% if Form || Content %>
				<section class="uk-section">
					<div class="uk-container">
						<h1>$Title</h1>
						$Content
						$Form
					</div>
				</section>
				<% end_if %>
			<% end_if %>
		</div>
	</div>
</div>