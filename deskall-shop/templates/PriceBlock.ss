
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$Lead
	</div>
</div>



<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
