
    <li>
        <a class="uk-accordion-title" href="#"><h4>$Title</h4></a>
        <div class="uk-accordion-content"></div>
    </li>
</ul><div id="$Name" class="dk-form-step $extraClass" data-title="$Title">
	<% if $Form.DisplayErrorMessagesAtTop %>
		<div class="error-container" aria-hidden="true" style="display: none;">
			<div>
				<h4></h4>
				<ul class="error-list"></ul>
			</div>
		</div>
	<% end_if %>

	<a class="uk-accordion-title"><h4>$Title</h4></a>
	<div class="uk-accordion-content">
		<% loop $Children %>
			$FieldHolder
		<% end_loop %>
	</div>
</div>
