
<% if Element.isVisible %>
<div class="element <% if $Element.Width %>$Element.Width<% else %>uk-width-1-1<% end_if %> <% if $Element.isChildren %>children<% end_if %> <% if $Element.isFirstMobile %>uk-flex-first@s<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	$Element
</div>
<% else %>
	<% if Element.ClassName == "CodeBlock" && Element.Position == "normal" %>
	$Element.Script
	<% end_if %>
<% end_if %>
