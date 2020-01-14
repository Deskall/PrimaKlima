<% if CurrentUser %>
	<% if Content %>
	<section class="uk-section uk-section-small no-bg">
		<div class="uk-container">
			<h1>$Title</h1>
			<div class="dk-text-content">$Content</div>
		</div>
	</section>
	<% else %>
		$ElementalArea
		<div class="element uk-background-cover" id="member-section">
			<section class="uk-section uk-section-xsmall">
				<div class="uk-container">
					<% if CurrentUser.inGroup('kandidaten') %>
					<% else_if CurrentUser.inGroup('arbeitgeber') %>
						<% include ProfilJobGiver %>
					<% end_if %>
				</div>
			</section>
		</div>
	<% end_if %>
<% else %>
	<section class="uk-section uk-section-small no-bg">
	<% include LoginOrRegister %>
	</section>
<% end_if %>


