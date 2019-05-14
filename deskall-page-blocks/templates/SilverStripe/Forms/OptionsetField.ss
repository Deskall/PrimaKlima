<ul $AttributesHTML>
	<div class="uk-child-width-auto" data-uk-grid>
		<% loop $Options %>
			<li class="$Class">
				<input id="$ID" class="radio uk-radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
				<label for="$ID">$Title</label>
			</li>
		<% end_loop %>
	</div>
</ul>
