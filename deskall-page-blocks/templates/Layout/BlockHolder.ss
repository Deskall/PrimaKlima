<% if Element.isVisible %>
<div class="element <% if $Element.isChildren %>children <% if $Element.Width %>$Element.Width<% end_if %><% if $Element.isFirstMobile %>uk-flex-first@s<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $Element.SimpleClassName.LowerCase<% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %><% if $Element.ExtraClass %> $Element.ExtraClass<% end_if %>" id="$Element.Anchor">
	<% if $Element.BackgroundImage %>
		<section class="uk-section $Element.Background uk-cover-container dk-overlay uk-section-large" <% if $Element.BackgroundImage.getExtension == "svg" %>data-src="$Element.BackgroundImage.URL"<% else %>data-src="$Element.BackgroundImage.ScaleWidth(350).URL" data-srcset="$Element.BackgroundImage.ScaleWidth(650).URL 650w,$Element.BackgroundImage.ScaleWidth(1200).URL 1200w, $Element.BackgroundImage.ScaleWidth(1600).URL 1600w, $Element.BackgroundImage.URL 2500w" data-sizes="100vw" data-uk-img<% end_if %>>
	<% else %>
		<section class="uk-section <% if $Element.Background %>$Element.Background with-background<% end_if %> uk-section-small">
	<% end_if %>				
			<div class="uk-container $Element.TextAlign <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
				<% if Element.TitleIcon %>
				<div class="uk-flex uk-flex-middle uk-margin-bottom">
					<div class="title-icon"><i class="fa fa-{$TitleIcon}"></i></div>
					<% if Element.isPrimary %>
						<h1 class="$Element.TitleAlign">$getPage.Title</h1>
					<% else %>
						<% if Element.Title && $Element.ShowTitle %>
							<% if $Element.isChildren %>
								<h3 class="$Element.TitleAlign">$Element.Title</h3>
							<% else %>
								<h2 class="$Element.TitleAlign">$Element.Title</h2>
							<% end_if %>
						<% end_if %>
					<% end_if %>
				</div>
				<% else %>
				<% if Element.isPrimary %>
					<h1 class="$Element.TitleAlign">$getPage.Title</h1>
				<% else %>
					<% if Element.Title && $Element.ShowTitle %>
						<% if $Element.isChildren %>
							<h3 class="$Element.TitleAlign">$Element.Title</h3>
						<% else %>
							<h2 class="$Element.TitleAlign">$Element.Title</h2>
						<% end_if %>
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