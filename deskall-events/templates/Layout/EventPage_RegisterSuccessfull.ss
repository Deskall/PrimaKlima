<% include HeaderSlide MenuTitle=$Event.Title %>

<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">

				<div class="element" id="event" data-event-id="$Date.ID">
					<h1>$Title</h1>
					<div class="uk-panel">
						$EventConfig.PaymentConfirmedLabel
						<div class="uk-margin">
							<a href="$Order.ReceiptFile.URL" target="_blank" title="Quittung herunterladen"><%t Event.DownloadInvoice 'Quittung herunterladen' %></a>
						</div>
						<h4><%t Event.CourseData 'Kurs Informationen' %></h4>
						<table class="uk-table uk-table-small uk-table-responsive">
							<thead><th><%t Event.Kurs 'Kurs' %></th><th><%t Event.Date 'Datum' %></th><th><%t Event.Place 'Ort' %></th><th class="uk-text-right"><%t Event.Price 'Preis' %></th></thead>
							<tbody><tr><td>$Event.Title</td><td><i class="icon icon-calendar uk-margin-small-right"></i>$Date.Date</td><td><i class="icon icon-ios-location uk-margin-small-right"></i>$Date.City</td><td class="uk-text-right@s">$Order.TotalPrice.Nice</td></tr></tbody>
						</table>
						
					</div>
				</div>
			
	</div>
</section>