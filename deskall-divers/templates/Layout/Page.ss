<% if ID < 0 || $noSlide %>
	<% include DefaultSlide %>
<% end_if %>

$ElementalArea

<% if Form %>
<section class="uk-section dk-background-white">
	<div class="uk-container">
		<h1>$Title</h1>
		$Form
	</div>
</section>
<% end_if %>
