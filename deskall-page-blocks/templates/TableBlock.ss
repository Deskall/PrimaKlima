
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	
	<% if LinkableLinkID > 0 %>
		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	<% end_if %>

	<% if Headers.exists %>
	<table class="uk-table">
		<thead>
			<% loop Headers %>
				<th class="$Format $TextAlign uk-text-nowrap">$Title</th>
			<% end_loop %>
		</thead>
	</table>
	<% end_if %>
