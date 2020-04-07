	<% if HTML %>
	<div class="dk-text-content uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		<% if CollapseText %>
				<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
				<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
			<% else %>
				$HTML
			<% end_if %>
	</div>
	<% end_if %>
	<% if LinkableLinkID > 0 %>
		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	<% end_if %>
