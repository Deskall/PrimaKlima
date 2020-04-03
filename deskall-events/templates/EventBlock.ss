<% if activeEvents.exists %>
<div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
	<% loop activeEvents %>
	<div>
		<div class="uk-card uk-card-default uk-card-body">
			<div class="uk-grid-small" data-uk-grid>
				<% if Images.first %>
				<div class="uk-width-1-3@m">
					<img src="$Images.first.FocusFill(250,250).URL" data-uk-img class="uk-border-circle" alt="$Images.first.Alt" />
				</div>
				<div class="uk-width-2-3@m">
				    <h3 class="uk-card-title">$Title</h3>
				    $Description
				    <div class="uk-text-right@m">
				    	<a href="$Link" class="uk-button button-gruen" title="<%t Event.SeeDetails 'Details ansehen' %>"><%t Event.SeeDetails 'Details ansehen' %></a>
				    </div>
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
		</div>
	</div>
	$EventStructuredData
	<% end_loop %>
</div>
<% else %>
<p><%t Event.NoEvents 'Keine Kurse am Moment' %></p>
<% end_if %>

<div class="uk-margin">
	<div class="uk-text-small">
		$Conditions
	</div>
</div>