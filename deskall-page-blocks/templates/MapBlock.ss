<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<% if Adresse %>
<div id="googlemap_{$ID}" class="google-map $Height" data-google-map="$ID" data-google-map-address="$Adresse" data-google-map-options="$getMapOptions">
	$InfoWindowHTML
</div>
<% end_if %>