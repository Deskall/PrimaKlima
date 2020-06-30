
<% if Element.isVisible %>
<div class="element <% if $Element.isChildren %>children <% if $Element.isFirstMobile %>uk-flex-first@s<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$AnchorTitle">
	$Element
</div>
<% else %>
	<% if Element.ClassName == "CodeBlock" && Element.Position == "normal" %>
		<% if $Element.Display %>
		<div class="element <% if $Element.isChildren %>children <% if $Element.isFirstMobile %>uk-flex-first@s<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$AnchorTitle">
			$Element
		</div>
		<% else %>
		$Element.Script
		<% end_if %>
	<% end_if %>
<% end_if %>
