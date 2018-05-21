<% if Element.isVisible %>
<div class="element <% if Background %> dk-overlay $Background<% end_if %> <% if Element.isChildren %>children<% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	$Element
</div>
<% end_if %>
