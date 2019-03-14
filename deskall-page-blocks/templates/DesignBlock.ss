
<div class="uk-position-relative" <% if FullHeight %>data-uk-height-viewport<% end_if %>>
	<div class="class-wrapper $TextVerticalAlign">
		<div class="dk-text-content $TextAlign $TextColumns<% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
	</div>
	<div class="uk-child-width-1-1" data-uk-grid>
		<% loop Resources %>
		<div class="$ExtraCssClass" <% if Animation %>data-uk-scrollspy="$Animation"<% end_if %> <% if Parallax %>data-uk-parallax="$Parallax"<% end_if %>>
			<% if Image.exists %>
			<div class="uk-cover-container uk-width-1-1 uk-height-1-1">
				<img src="$Image.ScaleWidth(1200).URL" alt="$Image.Title" data-uk-cover />
			</div>
			<% end_if %>
		</div>
		<% end_loop %>
	</div>
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
