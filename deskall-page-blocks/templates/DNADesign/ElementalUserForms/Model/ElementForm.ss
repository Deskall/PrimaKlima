<% if isVisible %>
	<div class="form-element__form $ExtraClass">
		<section class="uk-section $Background">
			<div class="uk-container <% if not FullWidth %>uk-container-medium<% end_if %>">
			    <% if $Title && $ShowTitle %>
			        <h2 class="form-element__title">$Title</h2>
			    <% end_if %>

			    $Form
			</div>
		</section>
	</div>
	<div style="clear: both"></div>
<% end_if %>