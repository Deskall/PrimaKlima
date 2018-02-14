<section class="uk-section $Background main">
	<div class="uk-container uk-container-medium">
		<div class="<% if $Style %>$CssStyle<% end_if %> uk-text-center">
			<% if $ShowTitle %>
		      <h1 class="uk-heading-primary">$Parent.getOwnerPage.Title</h1>
		    <% end_if %>
		    <div class="uk-text-lead">
			    $HTML
			</div>
		</div>
	</div>
</section>