	<% if activeCart.exists %>
	<% include MobileCartContainer %>
	<% end_if %>
	<div class="uk-background-muted">
		<div class="uk-container">
			$BreadCrumbs
		</div>
	</div>

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

