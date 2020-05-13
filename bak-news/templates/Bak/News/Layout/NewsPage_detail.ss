	<% with News %>
	<div class="element">
		<section class="uk-section uk-section-small">
			<div class="uk-container">
				<h1>$Title</h1>
				<% if $Lead %>
				$Lead
				<% end_if %>
				<% if Content %>
					$Content
				<% end_if %>
			</div>
		</section>
	</div>
	<% end_with %>