<% include Includes\DefaultSlider %>

<% if not Content %>
$ElementalArea
<% end_if %>
<div class="element" id="member-section">
	<section class="uk-section uk-padding-remove">
		<div class="uk-container">
			<% if Content %>
			<h1>$Title</h1>
			<div class="uk-width-xlarge member-section-container">
				$Content
			</div>
			<% else %>
				<% if CurrentUser %>
				<div class="uk-width-xlarge member-section-container">
				$AlreadyConnected
				</div>
				<% else %>
					<div class="uk-width-xlarge member-section-container">
						 $RegisterForm
					</div>
				<% end_if %>
			<% end_if %>
		</div>
	</section>
</div>
