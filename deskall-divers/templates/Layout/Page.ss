<% if ID < 0 || $firstBlockSlide %>
	<% include DefaultSlide %>
<% end_if %>

$ElementalArea

<% if Form || Content %>
<section class="uk-section">
	<div class="uk-container">
		<h1>$Title</h1>
		$Content
		$Form
	</div>
</section>
<% end_if %>
