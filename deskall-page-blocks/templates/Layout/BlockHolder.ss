<% if Element.isVisible %>
<div class="element $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	<section class="uk-section <% if $Element.FullWidth || $Element.$Element.BackgroundImage %>$Element.Background<% end_if %> <% if $Element.BackgroundImage %> dk-overlay uk-section-xlarge uk-background-cover" style="background-image:url($Element.BackgroundImage.URL);"<% end_if %>">
		<div class="uk-container <% if $Element.FullWidth %>uk-container-expand<% else_if not $Element.BackgroundImage %>$Element.Background<% end_if %>">
			<% if $Element.ShowTitle %>
				<% if $SimpleClassName.LowerCase == "leadblock" %>
				<h1 class="uk-heading-primary">$Element.Parent.getOwnerPage.Title</h1>
				<% else %>
				<h2>$Element.Title</h2>
				<% end_if %>
			<% end_if %>
			$Element
		</div>
	</section>
</div>
<% end_if %>
