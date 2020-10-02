<% include TextBlock %>

<div class="uk-child-width-auto" data-uk-grid="masonry:true;">
	<% loop activeReferences %>
	<div class="uk-card uk-box-shadow-small reference-box uk-flex uk-flex-center uk-flex-middle">
		$Logo.FitMax(150,150)
	</div>
	<% end_loop %>
</div>