<% if HTML %>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		<% if CollapseText %>
				<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
				<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
				<% else %>
				$HTML
				<% end_if %>
	</div>
<% end_if %>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<div class="uk-visible@m">
		<ul class="$FeaturesColumns uk-grid-small uk-margin-medium $FeaturesTextAlign" data-uk-grid>
		<% loop activeFeatures %> 
		    <li <% if Top.FeaturesTextBig %>class="uk-text-large"<% end_if %>><span class="dk-large-icon <% if Top.FeaturesTextBig %>uk-margin-medium-right<% else %>uk-margin-small-right<% end_if %>" data-uk-icon="icon: $Top.IconItem;<% if Top.FeaturesTextBig %>ratio:1.75;<% end_if %>"></span>$Text</li>
		<% end_loop %>
		</ul>
	</div>
	<div class="uk-hidden@m">
		<ul class="$FeaturesColumns uk-grid-small uk-margin-medium $FeaturesTextAlign" data-uk-grid>
		<% loop activeFeatures %> 
		    <li><span class="dk-large-icon uk-margin-small-right" data-uk-icon="icon: $Top.IconItem;"></span>$Text</li>
		<% end_loop %>
		</ul>
	</div>
<% end_if %>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>