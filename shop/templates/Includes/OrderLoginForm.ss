<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>

        <% if $Message %>
                <div class="cms-security__container__error message $MessageType">
                    <p id="{$FormName}_error">Ihre Eingaben scheinen nicht richtig zu sein. Bitte versuchen Sie es erneut.</p>
                </div>
        <% end_if %>
		<% loop $Fields %>
			$FieldHolder
		<% end_loop %>
		<div class="clear"><!-- --></div>

	<% if $Actions %>
	<div class="btn-toolbar">
		<% loop $Actions %>
			$Field
		<% end_loop %>
	</div>
	<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
