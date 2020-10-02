<% include TextBlock %>

<div class="uk-child-width-auto uk-grid-small" data-uk-grid="masonry:true;" data-uk-scrollspy="target:.reference-box;cls:uk-animation-fade;delay:100;">
	<% loop activeReferences %>
	<div class="reference-box uk-flex uk-flex-center uk-flex-middle">
		$Logo.FitMax(150,150)
	</div>
	<% end_loop %>
</div>