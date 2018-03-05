<% if Element.isVisible %>
<div class="element $TextAlign $TextColumns <% if Element.isChildren %>children<% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	$Element
</div>
<% end_if %>
