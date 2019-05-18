	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="dk-list $FeaturesColumns $FeaturesTextAlign uk-grid-small uk-margin-medium" data-uk-grid>
	<% loop activeFeatures %> 
	    <li><div class="uk-inline"><div><span class="<% if Top.FeaturesTextBig %>dk-large-icon uk-text-large<% end_if %>" data-uk-icon="icon: $Top.IconItem;"></span></div><div><span class="icon-text">$Text</span></div></div></li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>