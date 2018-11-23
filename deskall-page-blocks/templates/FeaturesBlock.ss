	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="dk-list $FeaturesColumns $FeaturesTextAlign" data-uk-grid>
	<% loop activeFeatures %> 
	    <li><span <% if Top.FeaturesTextBig %>class="dk-large-icon uk-text-large"<% end_if %> data-uk-icon="icon: $Top.IconItem;">$Text</span></li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>