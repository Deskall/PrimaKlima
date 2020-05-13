	<% with News %>
	<div class="element">
		<section class="uk-section uk-section-small">
			<div class="uk-container">
				<h1>$Title</h1>
				<div class="uk-flex">
					<% if Image %><img src="$Image.ScaleWidth(350).URL" /><% end_if %>
					<div class="dk-text-content">
						<% if $Lead %>
							$Lead
						<% end_if %>
						<% if $Content %>
							$Content
						<% end_if %>
					</div>
				</div>
			</div>
		</section>
	</div>
	<% end_with %>