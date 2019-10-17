<% if HTML %>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
<% end_if %>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="$FeaturesColumns uk-grid-small uk-margin-medium $FeaturesTextAlign" data-uk-grid>
	<% loop activeFeatures %> 
	    <li <% if Top.FeaturesTextBig %>class="uk-text-large"<% end_if %>><span class="dk-large-icon <% if Top.FeaturesTextBig %>uk-margin-right<% else %>uk-margin-small-right<% end_if %>" data-uk-icon="icon: $Top.IconItem;<% if Top.FeaturesTextBig %>ratio:1.75;<% end_if %>"></span>$Text</li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>