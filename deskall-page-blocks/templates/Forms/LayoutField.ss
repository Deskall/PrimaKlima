<div $AttributesHTML data-ici="true">
	<% loop $Options %>
	<div class="$Class">
		<label for="$ID"><i class="font-icon-block-content"></i>
			<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
		</label>
	</div>
	<% end_loop %>
</div>