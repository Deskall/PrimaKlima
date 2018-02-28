<% if Element.isVisible %>
<div class="element <% if $Element.isChildren %>children<% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	<section class="uk-section $Element.Background <% if $Element.BackgroundImage %> dk-overlay uk-section-large uk-background-cover" style="background-image:url($Element.BackgroundImage.URL);"<% end_if %>">
		<div class="uk-container <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
			<% if $Element.ShowTitle %>
				<% if $Element.isChildren %>
					<h3>$Element.Title</h3>
				<% else %>
					<% if $SimpleClassName.LowerCase == "leadblock" %>
					<h1>$Element.Parent.getOwnerPage.Title</h1>
					<% else %>
					<h2>$Element.Title</h2>
					<% end_if %>
				<% end_if %>
			<% end_if %>
			$Element
		</div>
	</section>
</div>
<% end_if %>