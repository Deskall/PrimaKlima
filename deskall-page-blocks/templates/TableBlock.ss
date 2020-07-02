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
	<% if Headers.exists %>
	<% if MobileFormat == "overflow" %><div class="uk-overflow-auto"><% end_if %>
	<table class="uk-table <% if Striped %>uk-table-striped<% end_if %> <% if Divider %>uk-table-divider<% end_if %> <% if Hover %>uk-table-hover<% end_if %> <% if MobileFormat == "stack" %>uk-table-responsive<% end_if %>">
		<thead>
			<% loop Headers %>
				<th class="$Format $TextAlign uk-text-nowrap">$Title</th>
			<% end_loop %>
		</thead>
		<tbody>
			<% loop $Rows %>
			<tr><% if $Header1 %><td>$Header1</td><% end_if %><% if $Header2 %><td>$Header2</td><% end_if %>
				<% if $Header3 %><td>$Header3</td><% end_if %><% if $Header4 %><td>$Header4</td><% end_if %>
				<% if $Header5 %><td>$Header5</td><% end_if %><% if $Header6 %><td>$Header6</td><% end_if %>
				<% if $Header7 %><td>$Header7</td><% end_if %><% if $Header8 %><td>$Header8</td><% end_if %>
				<% if $Header9 %><td>$Header9</td><% end_if %><% if $Header10 %><td>$Header10</td><% end_if %>
			</tr>
			<% end_loop %>
		</tbody>
	</table>
	<% if MobileFormat == "overflow" %></div><% end_if %>
	<% end_if %>

	<% if LinkableLinkID > 0 %>
		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	<% end_if %>
