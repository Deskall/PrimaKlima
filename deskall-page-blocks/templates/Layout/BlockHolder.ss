<% if Element.isVisible %>

<div class="element <% if $Element.isChildren %>children <% if $Element.isFirstMobile %>uk-flex-first@s<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $SimpleClassName.LowerCase<% if $StyleVariant %> $StyleVariant<% end_if %><% if $ExtraClass %> $ExtraClass<% end_if %>" id="$Anchor">
	<section class="uk-section $Element.Background <% if $Element.BackgroundImage %> uk-cover-container dk-overlay uk-section-large<% else %>uk-section-small<% end_if %>">
		<% if $Element.BackgroundImage %>
			<% if $Element.BackgroundImage.getExtension == "svg" %><img src="$Element.BackgroundImage.URL" alt="$Element.BackgroundImage.AltTag($Title)" title="$Element.BackgroundImage.TitleTag($Title)" width="$Element.BackgroundImage.Width" height="$Element.BackgroundImage.Height" data-uk-cover /><% else %>$Element.BackgroundImage.Slides(2500,$Element.Title)<% end_if %>
		<% end_if %>
		<div class="uk-container $TextAlign <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
			<% if $SimpleClassName.LowerCase == "leadblock" %>
				<% if Element.Parent.getOwnerPage.Title && Element.ShowTitle %><h1>$Element.Parent.getOwnerPage.Title</h1><% end_if %>
			<% else %>
				<% if Title && $Element.ShowTitle %>
					<% if $Element.isChildren %>
						<h3>$Element.Title</h3>
					<% else %>
						<h2>$Element.Title</h2>
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