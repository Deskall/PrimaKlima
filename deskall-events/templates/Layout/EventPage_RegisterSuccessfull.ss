<% include HeaderSlide %>

<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">

				<div class="element" id="event" data-event-id="$Date.ID">
					<h1>$Title</h1>
					<div class="uk-panel">
						$EventConfig.PaymentConfirmedLabel
						<div class="uk-margin">
							<a href="$Order.ReceiptFile.URL" target="_blank" title="Quittung herunterladen">Quittung herunterladen</a>
						</div>
						<h4>Informations</h4>
						<table class="uk-table uk-table-small">
							<tr><td><%t Event.Label 'Seminar' %></td><td class="uk-table-expand">$Event.Title</td></tr>
							<tr><td><%t Event.City 'Ort' %></td><td>$Date.City</td></tr>
							<tr><td><%t Event.Dates 'Datum' %></td><td>$Date.Date</td></tr>
							<tr><td><%t Event.Price 'Preis' %></td><td>$Order.Price €</td></tr>
						</table>
						
					</div>
				</div>
			
	</div>
</section>