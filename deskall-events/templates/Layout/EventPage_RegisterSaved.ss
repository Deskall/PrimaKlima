<% include HeaderSlide %>

<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">

				<div class="element" id="event" data-event-id="$Date.ID">
					<h1>$Title</h1>
					<div class="uk-panel">
						$EventConfig.PaymentConfirmedLabel
						<div class="uk-margin">
							<a href="$Order.BillFile.URL" target="_blank" title="Rechnung herunterladen">Rechnung herunterladen</a>
						</div>
						<h4>Informations</h4>
						<table class="uk-table uk-table-small uk-table-responsive">
							<thead><th><%t Event.Kurs 'Kurs' %></th><th><%t Event.Date 'Datum' %></th><th><%t Event.Place 'Ort' %></th><th class="uk-text-right"><%t Event.Price 'Preis' %></th></thead>
							<% with $Date %>
							<tbody><tr><td>$Event.Title</td><td><i class="icon icon-calendar uk-margin-small-right"></i>$Date</td><td><i class="icon icon-ios-location uk-margin-small-right"></i>$City</td><td>$Price.Nice</td></tr></tbody>
							<% end_with %>
						</table>
						
					</div>
				</div>
			
	</div>
</section>