<% include HeaderSlide %>

<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4">
				<% include EventSidebar %>
			</div>
			<div class="uk-width-3-4">
				<div class="uk-margin"><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="fa fa-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div>
				<div class="element" id="event" data-event-id="$Date.ID" data-price="$Date.Price">
					<h1>$Title</h1>
					<div class="uk-panel">
						<table class="uk-table uk-table-small">
							<tr><td><%t Event.Label 'Seminar' %></td><td class="uk-table-expand">$Event.Title</td></tr>
							<tr><td><%t Event.City 'Ort' %></td><td>$Date.City</td></tr>
							<tr><td><%t Event.Dates 'Datum' %></td><td>$Date.Date</td></tr>
							<tr><td><%t Event.Price 'Preis' %></td><td>$Date.Price €</td></tr>
						</table>
						<div class="uk-margin-large">
							<h3><%t Event.Voucher 'Gutschein' %></h3>
							<p><%t Event.VoucherLabel 'Geben Sie hier Ihre Gutschein-Nr. und klicken Sie an "Gutschein prüfen".' %></p>
							<form class="uk-form uk-form-horizontal" method="post" action="{$Link}VoucherForm" data-form-voucher>
								<input type="text" name="voucher" class="uk-input uk-width-medium" placeholder="<%t Event.VoucherPLH 'zb: A12B3C4D' %>" required />
								<input type="hidden" name="event" value="$Date.ID" />
								<input type="submit" class="uk-button uk-button-primary" value="<%t Event.VoucherCheck 'Gutschein prüfen' %>" />
							</form>
						</div>
						<div class="uk-margin">
							<div data-uk-switcher="toggle: > *">
								<button class="uk-button uk-button-secondary uk-button-large" type="button"><%t Event.PayBill 'Zahlen mit Rechnung' %></button>
								<button class="uk-button uk-button-secondary uk-button-large" type="button"><%t Event.PayOnline 'Online Zahlen (Paypal / Kreditkarte)' %></button>
							</div>
						
							<ul class="uk-switcher uk-margin">
							    <li>
							    	<h4><%t Event.PayBill 'Zahlen mit Rechnung' %></h4>
							    	$EventConfig.BillPayLabel
							    	$RegisterForm
							    </li>
							    <li>
							    	<h4><%t Event.PayOnline 'Online Zahlen (Paypal / Kreditkarte)' %></h4>
							    	$EventConfig.OnlinePayLabel
							    	<div id="paypal-button-container"></div>
							    </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>