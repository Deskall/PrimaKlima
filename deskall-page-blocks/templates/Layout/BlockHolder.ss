<% if Element.isVisible %>
<<<<<<< HEAD
<div class="element <% if $Element.isChildren %>children <% if $Element.Width %>$Element.Width<% end_if %><% if $Element.isFirstMobile %>uk-flex-first<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $Element.SimpleClassName.LowerCase<% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %><% if $Element.ExtraClass %> $Element.ExtraClass<% end_if %>" id="$Element.Anchor" <% if Element.Animation %>data-uk-scrollspy="$Animation"<% end_if %>>
=======
<div class="element <% if $Element.isChildren %>children <% if $Element.Width %>$Element.Width<% end_if %> <% if $Element.isFirstMobile %>uk-flex-first<% end_if %> <% if $Element.isFirst %>uk-flex-first@m<% end_if %><% end_if %> $Element.SimpleClassName.LowerCase<% if $Element.StyleVariant %> $Element.StyleVariant<% end_if %> $Element.ExtraClass" id="$Element.Anchor" <% if Element.Animation %>data-uk-scrollspy="cls: $Element.Animation;target: $Element.AnimationTarget;"<% end_if %>>
>>>>>>> master
	<% if $Element.BackgroundImage.exists %>
		<section class="uk-section $Element.Background uk-cover-container dk-overlay uk-section-large uk-background-blend-overlay with-background" <% if $Element.BackgroundImage.getExtension == "svg" %>data-src="$Element.BackgroundImage.URL"<% else %>data-src="$Element.BackgroundImage.FocusFillMax(1200,800).URL" data-srcset="$Element.BackgroundImage.FocusFillMax(650,420).URL 650w,$Element.BackgroundImage.URL 1200w" data-sizes="100vw" data-uk-img<% end_if %>>
	<% else %>
		<section class="uk-section <% if $Element.Background != "no-bg" %>$Element.Background with-background<% end_if %> uk-section-small">
	<% end_if %>				
			<div class="uk-container $Element.TextAlign <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
				<% if not $Element.isChildren %><div class="uk-child-width-1-1 uk-grid-small $BlockAlignment" data-uk-grid>
					<div class="$Element.Width"><% end_if %>
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
							<h1 class="$Element.TitleAlign">$getRealPage.Title</h1>
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
					<% if not $Element.isChildren %>
					</div>
				</div>
				<% end_if %>
			</div>
		</section>
</div>
<% end_if %>