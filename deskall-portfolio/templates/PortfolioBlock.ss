<% include TextBlock %>

<div class="uk-child-width-1-5 uk-transition-toggle" data-uk-grid="masonry:true;" data-uk-scrollspy="target:.reference-box;cls:.uk-animation-fade;delay:500;" tabindex="0">
	<% loop activeReferences %>
	<div class="reference-box uk-text-center">
		$Logo
	</div>
	<% end_loop %>
</div>