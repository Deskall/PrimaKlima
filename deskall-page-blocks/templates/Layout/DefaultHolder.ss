
<% if Element.isVisible %>
<div class="element $Background <% if Element.isChildren %>children<% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	$Element
</div>
<% else %>
	<% if Element.ClassName == "CodeBlock" && Element.Position == "normal" %>
	$Element.Script
	<% end_if %>
<% end_if %>
