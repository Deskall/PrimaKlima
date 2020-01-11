
	<% if $ID > 0 %>
	<section class="uk-section uk-padding-remove">
		<div class="uk-container">
			<div class="uk-grid-small uk-grid-match" data-uk-grid>
				<div class="uk-width-1-4@m uk-width-1-5@l uk-visible@m">
					<aside class="uk-padding-small uk-background-muted">
						<% include SideBar %>
					</aside>
				</div>
				<div class="uk-width-3-4@m uk-width-4-5@l">
					$ElementalArea
				</div>
			</div>
		</div>
	</section>
	<% else %>
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
	