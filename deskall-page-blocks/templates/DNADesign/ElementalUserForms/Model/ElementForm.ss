<% if isVisible %>
	<div class="form-element__form $ExtraClass">
		<% if $BackgroundImage.exists %>
		<section class="uk-section $Background uk-cover-container dk-overlay uk-section-large with-background" <% if $BackgroundImage.getExtension == "svg" %>data-src="$BackgroundImage.URL"<% else %>data-src="$BackgroundImage.ScaleWidth(1200).URL" data-srcset="$BackgroundImage.ScaleWidth(650).URL 650w,$BackgroundImage.ScaleWidth(1200).URL 1200w, $BackgroundImage.ScaleWidth(1600).URL 1600w, $BackgroundImage.URL 2500w" data-sizes="100vw" data-uk-img<% end_if %>>
	<% else %>
		<section class="uk-section <% if $Background != "no-bg" %>$Background with-background<% end_if %> uk-section-small">
	<% end_if %>		
			<div class="uk-container <% if not FullWidth %>uk-container-medium<% end_if %>">
			<% if not $isChildren %><div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
					<div class="$Width"><% end_if %>
			    <% if $Title && $ShowTitle %>
			    	<% if isChildren %>
			    	<h3 class="form-element__title">$Title</h3>
			    	<% else %>
			        <h2 class="form-element__title">$Title</h2>
			        <% end_if %>
			    <% end_if %>

			    <% if HTML %>
			    <div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
					$HTML
				</div>
				<% end_if %>
			    $CustomForm
			   <% if not $isChildren %>
			    	</div>
			    </div>
			    <% end_if %>
			</div>
		</section>
	</div>
	<div style="clear: both"></div>
<% end_if %>