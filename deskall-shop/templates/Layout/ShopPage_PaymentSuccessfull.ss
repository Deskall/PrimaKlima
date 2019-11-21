<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-visible@m">
				<% include ProductSidebar %>
			</div>
			<div class="uk-width-3-4@m">
				<div class="element" id="event" data-event-id="$Date.ID">
					<h1>$Title</h1>
					<div class="uk-panel">
						$Order.ProductConfig.BuySuccessfullMessage
						<div class="uk-margin">
							<div class="uk-card uk-card-default uk-card-hover uk-card-body">
							    <h3 class="uk-card-title"><%t Order.YourOrder 'Ihre Bestellung' %></h3>
							    <table class="uk-table uk-table-small">
									<tr><td>$Order.Nummer</td><td>$Order.Created.Date</td><td class="uk-table-expand">$Order.Quantity * $Product.Title</td><td>$Order.Price €</td><td><% if Order.isPaid %><a href="$Order.ReceiptFile.URL" target="_blank" title="Quittung herunterladen" class="uk-button uk-button-primary" download><i class="fa fa-print uk-margin-small-right"></i><%t Order.DownloadReceipt 'Quittung herunterladen' %></a><% else %><a href="$Order.BillFile.URL" target="_blank" title="Rechnung herunterladen" class="uk-button uk-button-primary" download><i class="fa fa-print uk-margin-small-right"></i><%t Order.DownloadBill 'Rechnung herunterladen' %></a><% end_if %></td></tr>
								</table>   
							</div>
						</div>
						<% if not Product.Online %>
						<div class="uk-margin">
						$Order.ProductConfig.TransportLabel
						</div>
						<% end_if %>
						<div class="uk-margin">
							<a href="shop/mein-konto" title="Ihr Konto"><%t Shop.GoToAccount 'zu Ihrem Konto' %></a>
							<% if $Product.Online %><a href="$Order.OnlineDeliveryLink" title="Ihr Produkt" class="uk-margin-left"><%t Shop.GoToProduct 'zu Ihrem Produkt' %></a><% end_if %>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>