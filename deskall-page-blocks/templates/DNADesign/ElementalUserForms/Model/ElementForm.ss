<% if isVisible %>
	<div class="form-element__form $ExtraClass">
		<section class="uk-section $Background">
			<div class="uk-container <% if not FullWidth %>uk-container-medium<% end_if %>">
			    <% if $Title && $ShowTitle %>
			    	<% if isChildren %>
			    	<h3 class="form-element__title">$Title</h3>
			    	<% else %>
			        <h2 class="form-element__title">$Title</h2>
			        <% end_if %>
			    <% end_if %>

			    $Form
			</div>
		</section>
	</div>
	<div style="clear: both"></div>
<% end_if %>