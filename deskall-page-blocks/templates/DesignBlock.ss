
<div class="uk-position-relative" <% if FullHeight %>data-uk-height-viewport<% end_if %>>
	<div class="class-wrapper $TextVerticalAlign">
		<div class="dk-text-content $TextAlign $TextColumns<% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
	</div>
	<% if Resources.exists %>
	<div class="uk-child-width-1-{$Resouces.count}" data-uk-grid>
		<% loop Resources %>
		<div class="$ExtraCssClass" <% if Animation %>data-uk-scrollspy="$Animation"<% end_if %> <% if Parallax %>data-uk-parallax="$Parallax"<% end_if %>>
			<% if Image.exists %>
				<img src="$Image.ScaleWidth(1200).URL" alt="$Image.Title" />
			<% end_if %>
		</div>
		<% end_loop %>
	</div>
	<% end_if %>
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
