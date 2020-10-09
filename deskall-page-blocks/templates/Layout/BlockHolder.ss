<% if Element.isVisible %>
<div class="element <% if $Element.isChildren %>children<% end_if %> <% if $Element.Width %>$Element.Width<% end_if %> <% if $Element.isFirstMobile %>uk-flex-first<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %> $Element.SimpleClassName.LowerCase<% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %><% if $Element.ExtraClass %> $Element.ExtraClass<% end_if %>" id="$Element.AnchorTitle" <% if Element.Animation %>data-uk-scrollspy="$Element.Animation"<% end_if %>>
	<% if $Element.BackgroundImage.exists %>
		<section class="uk-section $Element.Background uk-cover-container dk-overlay uk-section-large with-background <% if $Element.BackgroundImageEffect %>uk-background-fixed<% end_if %>" data-src="$Element.BackgroundImage.URL" data-uk-img>
	<% else %>
		<section class="uk-section <% if $Element.Background != "no-bg" %>$Element.Background with-background<% end_if %> $Element.SectionPadding">
	<% end_if %>				
			<div class="uk-container $Element.TextAlign <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
				<% if not $Element.isChildren %><div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
					<div class="$Element.Width"><% end_if %>
						
						<% if Element.isPrimary %>
							<h1 class="$Element.TitleAlign"><% if getPage.TitleDisplayed %>$getPage.TitleDisplayed<% else %>$getPage.Title<% end_if %></h1>
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
					<% if not $Element.isChildren %>
					</div>
				</div>
				<% end_if %>
			</div>
		</section>
</div>
<% end_if %>