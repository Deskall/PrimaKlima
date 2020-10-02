<% include TextBlock %>

<div class="uk-child-width-auto" data-uk-grid tabindex="0">
	<% loop activeReferences %>
	<div class="uk-card uk-box-shadow-small reference-box uk-text-center uk-flex uk-flex-middle">
		$Logo.FitMax(150,150)
	</div>
	<% end_loop %>
</div>