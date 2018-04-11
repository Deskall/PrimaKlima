<div id="$Name" class="dk-form-step $extraClass" data-title="$Title">
	<% if $Form.DisplayErrorMessagesAtTop %>
		<div class="error-container" aria-hidden="true" style="display: none;">
			<div>
				<h4></h4>
				<ul class="error-list"></ul>
			</div>
		</div>
	<% end_if %>

	<h4 class="uk-accordion-title">$Title</h4>
	<div class="uk-accordion-content">
		<% loop $Children %>
			$FieldHolder
		<% end_loop %>
	</div>
</div>
