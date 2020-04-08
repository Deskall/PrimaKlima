<% if Element.isVisible %>
<div class="element <% if $Element.isChildren %>children <% if $Element.Width %>$Element.Width<% end_if %> <% if $Element.isFirstMobile %>uk-flex-first<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $Element.SimpleClassName.LowerCase<% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %><% if $Element.ExtraClass %> $Element.ExtraClass<% end_if %>" id="$Element.AnchorTitle" <% if Element.Animation %>data-uk-scrollspy="cls: $Element.Animation;target: $Element.AnimationTarget;"<% end_if %>>
	
	$Element
		
</div>
<% end_if %>