<ul $AttributesHTML>
	<% loop $Options %>
		<li class="$Class">
			<label for="$ID"><img src="$Icon" class="dk-icon" /></label>
			<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
			<%-- <label for="$ID">$Title</label> --%>
		</li>
	<% end_loop %>
</ul>
