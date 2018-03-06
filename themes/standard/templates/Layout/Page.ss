<% if ID < 0 || $noSlide %>
ici
	<% include DefaultSlide %>
<% end_if %>

$ElementalArea

<% if Form %>
<section class="uk-section dk-background-white">
	<div class="uk-container">
		$Form
	</div>
</section>
<% end_if %>
