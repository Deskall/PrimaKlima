	<div class="uk-grid-small" data-uk-grid>
		<div class="uk-width-1-4@m uk-width-1-5@l uk-visible@m">
		</div>
		<div class="uk-width-3-4@m uk-width-4-5@l">
			$ElementalArea
		</div>
	</div>
	
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
	