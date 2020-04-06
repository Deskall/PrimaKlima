
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
	<% end_if %>
