<% if Element.isVisible %>

<div class="element <% if $Element.isChildren %>children <% if $Element.isFirstMobile %>uk-flex-first@s<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $Element.SimpleClassName.LowerCase<% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %><% if $Element.ExtraClass %> $Element.ExtraClass<% end_if %>" id="$Element.Anchor">
	<section class="uk-section $Element.Background <% if $Element.BackgroundImage %> uk-cover-container dk-overlay uk-section-large<% else %>uk-section-small<% end_if %>">
		<% if $Element.BackgroundImage %>
			<% if $Element.BackgroundImage.getExtension == "svg" %><img src="$Element.BackgroundImage.URL" alt="$Element.BackgroundImage.AltTag($Title)" title="$Element.BackgroundImage.TitleTag($Title)" width="$Element.BackgroundImage.Width" height="$Element.BackgroundImage.Height" data-uk-cover /><% else %>$Element.BackgroundImage.Overlays($Element.BackgroundImage.Width, $Element.BackgroundImage.Height,$Element.Title)<% end_if %>
		<% end_if %>
		<div class="uk-container $Element.TextAlign <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
			<% if $Element.SimpleClassName.LowerCase == "leadblock" && Element.isPrimary %>
				<% if Element.Parent.getOwnerPage.Title && Element.ShowTitle %><h1>$Element.Parent.getOwnerPage.Title</h1><% end_if %>
			<% else %>
				<% if Element.Title && $Element.ShowTitle %>
					<% if $Element.isChildren %>
						<h3 class="$Element.TitleAlign">$Element.Title</h3>
					<% else %>
						<h2 class="$Element.TitleAlign">$Element.Title</h2>
					<% end_if %>
				<% end_if %>
			<% end_if %>
			<div class="uk-panel">
				$Element
			</div>
		</div>
	</section>
</div>
<% end_if %>