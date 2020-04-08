<% include HeaderSlide %>
<section class="uk-section uk-background-muted uk-padding-small">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb uk-margin-remove">
			    <li><a href="$EventConfig.MainPage.Link">$EventConfig.MainPage.MenuTitle.XML</a></li>
			    <li><span>$Event.Title</span></li>
			</ul>
		</div>
	</div>
</section>
<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">

				<%-- <div class="uk-margin"><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="fa fa-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div> --%>
				<div class="element" id="event" data-event-id="$Date.ID" data-price="$Date.Price">
					<h1>$Title</h1>
					<div class="uk-panel">
						<table class="uk-table uk-table-small uk-table-striped uk-table-middle">
							<thead><th><%t Event.Title 'Kurs' %></th><th><%t Event.Dates 'Datum' %></th><th><%t Event.City 'Ort' %></th><th><%t Event.Price 'Preis' %></th></thead>
							<tbody>
							<% with Date %>
							<tr><td>$Event.Title</td><td><i class="icon icon-calendar uk-margin-small-right"></i>$Date</td><td><i class="icon icon-ios-location uk-margin-small-right"></i>$City</td><td>$Price.Nice</td></tr>
							<% end_with %>
							</tbody>
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
</section>