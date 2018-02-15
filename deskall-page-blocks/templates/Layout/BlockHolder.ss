<% if Element.isVisible %>
<div class="element $Element.SimpleClassName.LowerCase <% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %><% if $Element.ExtraClass %> $Element.ExtraClass<% end_if %>" id="$Element.Anchor">
	<section class="uk-section <% if $Element.BackgroundImage %>uk-background-cover<% end_if %>" <% if $Element.BackgroundImage %>style="background-image:url($Element.BackgroundImage.URL);"<% end_if %>>
		<div class="uk-container <% if Element.FullWidth %>uk-container-expand<% end_if %>">
			$Element
		</div>
	</section>
</div>
<% end_if %>
