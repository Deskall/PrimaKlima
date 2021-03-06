
<% if $Element.ClassName == "DNADesign\ElementalVirtual\Model\ElementVirtual" %>
<div class="element <% if $Element.isChildren %>children<% end_if %> $ClassName $LinkedElement.ClassName<% if $LinkedElement.ExtraClass %> $LinkedElement.ExtraClass<% end_if %>" id="e{$LinkedElement.ID}">
    $LinkedElement
</div>
<% else_if Element.isVisible %>
<div class="element <% if $Element.isChildren %>children<% end_if %> <% if $Element.Width %>$Element.Width<% end_if %> <% if $Element.isFirstMobile %>uk-flex-first<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Element.AnchorTitle">
	$Element
</div>
<% else %>
	<% if Element.ClassName == "CodeBlock" && Element.Position == "normal" %>
	<div hidden>$Element</div>
	<% end_if %>
<% end_if %>
