	<% if activeCart.exists %>
	<% include MobileCartContainer %>
	<% end_if %>

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
	<% if $ID > 0 %> 
		<% include Sidebar %>
	<% end_if %>
