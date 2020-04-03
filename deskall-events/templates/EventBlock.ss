<% if activeEvents.exists %>
<div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
	<% loop activeEvents %>
	<div>
		<div class="uk-card uk-card-default uk-card-hover uk-padding-small uk-width-1-1">
			<div class="uk-card-title">$Title</div>
			<div class="uk-margin">
				$Description.limitWordCount(50)
			</div>
			<a href="$Link" title="<%t Event.SeeDetails 'Details ansehen' %>"><%t Event.SeeDetails 'Details ansehen' %></a>
			<% if activeDates.Exists %>
			<table class="uk-table uk-table-small uk-table-hover">
				<% loop activeDates %>
				<tr class="uk-padding-remove"><td>$City</td><td>$Date</td><td>$Price €*</td><td><% if isOpen %><a href="$RegisterLink"><%t Event.Register 'jetzt anmelden' %></a><% else %><% if isFull %><%t Event.Full 'Ausgebucht' %><% else %><%t Event.NotOpen 'Anmeldung nicht geöffnet' %><% end_if %><% end_if %></td></tr>
				$EventDateStructuredData
				<% end_loop %>
			</table>
			<% end_if %>
		</div>
	</div>
	$EventStructuredData
	<% end_loop %>
</div>
<% else %>
<p><%t Event.NoEvents 'Keine Seminare am Moment' %></p>
<% end_if %>

<div class="uk-margin">
	<div class="uk-text-small">
		$Conditions
	</div>
</div>