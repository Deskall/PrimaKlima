
<div class="uk-position-relative" data-uk-height-viewport>
	<div class="class-wrapper">
		<div class="dk-text-content $TextAlign  $TextColumns<% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
	</div>
		<% loop Resources %>
		<div class="$ExtraCssClass">
			$Image
		</div>
		<% end_loop %>

</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
