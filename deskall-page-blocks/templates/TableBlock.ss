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
	<table class="uk-table <% if MobileFormat == "stack" %>uk-visible@m<% end_if %><% if Striped %>uk-table-striped<% end_if %> <% if Divider %>uk-table-divider<% end_if %> <% if Hover %>uk-table-hover<% end_if %> <% if MobileFormat == "stack" %>uk-table-responsive<% end_if %>">
		<thead>
			<% loop Headers %>
				<th class="$Format $TextAlign mt-nowrap">$Title</th>
			<% end_loop %>
		</thead>
		<tbody>
			<% loop $Rows %>
			<tr>
				<% if $Header1 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',1).first.Title}:</span><% end_if %>$Header1
					</td>
				<% end_if %>
				<% if $Header2 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',2).first.Title}:</span><% end_if %>$Header2
					</td>
				<% end_if %>
				<% if $Header3 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',3).first.Title}:</span><% end_if %>$Header3
					</td>
				<% end_if %>
				<% if $Header4 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',4).first.Title}:</span><% end_if %>$Header4
					</td>
				<% end_if %>
				<% if $Header5 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',5).first.Title}:</span><% end_if %>$Header5
					</td>
				<% end_if %>
				<% if $Header6 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',6).first.Title}:</span><% end_if %>$Header6
					</td>
				<% end_if %>
				<% if $Header7 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',7).first.Title}:</span><% end_if %>$Header7
					</td>
				<% end_if %>
				<% if $Header8 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',8).first.Title}:</span><% end_if %>$Header8
					</td>
				<% end_if %>
				<% if $Header9 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',9).first.Title}:</span><% end_if %>$Header9
					</td>
				<% end_if %>
				<% if $Header10 %>
					<td><% if Top.MobileFormat == "stack" %><span class="uk-hidden@m uk-margin-small-right">{$Top.Headers.filter('Sort',10).first.Title}:</span><% end_if %>$Header10
					</td>
				<% end_if %>
			</tr>
			<% end_loop %>
		</tbody>
	</table>

	<% if MobileFormat == "overflow" %></div><% end_if %>
	<% end_if %>

	<% if LinkableLinkID > 0 %>
		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	<% end_if %>
