
		    <div class="dk-text-content uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			    $HTML
			</div>
			
			<% if LinkableLinkID > 0 %>
				<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
			<% end_if %>
		