
<div class="uk-position-relative" data-uk-height-viewport>
	<div class="class-wrapper $TextVerticalAlign">
		<div class="dk-text-content $TextAlign $TextColumns<% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
	</div>
		<% loop Resources %>
		<div class="$ExtraCssClass <% if Image.exists %>uk-cover-container<% end_if %>" <% if Animation %>data-uk-scrollspy="$Animation"<% end_if %>>
			<img src="$Image.ScaleWidth(350).URL" alt="$Image.Title" data-uk-cover />
		</div>
		<% end_loop %>

</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
