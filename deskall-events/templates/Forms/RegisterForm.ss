<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>

	<div class="uk-container">
		<ul id="tab-switcher" data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
			<li <% if $activeTab == "address" %>class="uk-active"<% end_if %>><a>1. <span><%t Shop.GiveAddress 'Angaben' %></span></a></li>
			<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a>2. <span><%t Shop.ChoosePayment 'Zahlungsmethod' %></span></a></li>
			<li <% if $activeTab == "payment" %>class="uk-active"<% end_if %>><a>3. <span><%t Shop.Confirm 'Bestätigung' %></span></a></li>
		</ul>
		<ul id="component-tab" class="uk-switcher">
			<li class="account-tab" data-index="0">
				
					<div class="uk-panel uk-padding-small">
						<h4><%t Checkout.Customer 'Ihre Angaben' %></h4>
						<div class="uk-width-1-2@m">
							<% with Fields.FieldByName('CustomerFields') %>
								$FieldHolder
							<% end_with %>
						</div>
					</div>
				
				<div class="uk-flex uk-flex-between">
					<a class="uk-button button-gruen with-chevron" data-step="forward"><%t Global.Forward 'Weiter' %></a>
				</div>
			</li>
			<li class="account-tab" data-index="1">
				<h3><%t Checkout.ChoosePaymentType 'Wählen Sie Ihre Zahlungsmethod' %></h3>
				<div class="uk-margin">
					<div class="uk-child-width-1-3@s" data-uk-grid data-uk-height-match=".uk-card">
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-cash"></i></div>
								<input id="cash-choice" class="uk-radio uk-margin-right" type="radio" name="PaymentMethod" value="cash" required="required"><label for="cash-choice"><%t Shop.CashPayLabel 'Barzahlung bei Abholung' %></label>
							</div>
						</div>
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-ios-paper"></i></div>
								<input id="bill-choice" class="uk-radio uk-margin-right" type="radio" name="PaymentMethod" value="bill" required="required"><label for="bill-choice"><%t Shop.BillPayLabel 'Zahlung bei Rechnung' %></label>
							</div>
						</div>
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-card"></i></div>
								<input id="online-choice" class="uk-radio uk-margin-right" type="radio" name="PaymentMethod" value="online" required="required"><label for="online-choice"><%t Shop.OnlinePayLabel 'Zahlung online bei Kreditkarte oder PayPal-Konto' %></label>
							</div>
						</div>
					</div>
				</div>
				<div class="uk-flex uk-flex-between">
					<a data-step="backward"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></a>
					<a class="uk-button button-gruen with-chevron" data-step="forward"><%t Global.Forward 'Weiter' %></a>
				</div>
				<% with Fields.FieldByName('PaymentType') %>
				$FieldHolder
				<% end_with %>
			</li>
			<li class="account-tab" data-index="2">
				<h3><%t Event.ReviewAndPay 'Prüfen und bestätigen Sie Ihre Anmeldung' %></h3>
				<div class="uk-panel uk-padding-small">
					<h3><%t Checkout.Voucher 'Gutschein' %></h3>
					<p><%t Checkout.VoucherLabel 'Geben Sie hier Ihre Gutschein-Nr. und klicken Sie an "Gutschein prüfen".' %></p>
					<div class="uk-flex uk-flex-wrap">
						<div class=" uk-width-medium uk-margin-small-right"><input type="text" name="voucher" class="uk-input" minlength="10" maxlength="10" placeholder="<%t Checkout.VoucherPLH 'zb: A12B3C4DEF' %>" /></div>
						<div>
							<a class="uk-button button-gruen with-chevron uk-text-nowrap" data-check-voucher><%t Checkout.VoucherCheck 'Gutschein prüfen' %></a>
						</div>
					</div>
				</div>
				<hr>
				
				<div id="summary" class="summary-course">
					<div class="uk-panel uk-background-muted uk-padding-small">
						<h4><%t Checkout.SummaryTitle 'Ihre Bestellung' %></h4>
						<table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-table-justify uk-table-responsive">
							<thead><th colspan="2"><%t Event.Kurs 'Kurs' %></th><th class="uk-text-right"><%t Event.Total 'Gesamtsumme' %></th></thead>
							<tbody class="uk-table-divider">
								<% with Controller.activeDate %>
								<tr><td colspan="3">$Event.Title</td><td>$Price.Nice</td></tr>
								<% end_with %>
							
								<tr id="voucher-row" hidden><td colspan="3" class="uk-text-right"><%t Event.Voucher 'Gutschein:' %></td><td id="voucher-price" class="uk-text-right">- </td></tr>
								<tr><td colspan="3" class="uk-text-right"><%t Event.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td id="mwst-price" class="uk-text-right">$Controller.activeDate.MwSt.Nice</td></tr>
								
								<tr class="uk-table-divider"><td colspan="3" class="uk-text-right"><strong><%t Event.TotalPrice 'Preis inklusive MwSt.' %></strong></td><td class="uk-text-right"><strong id="total-price" data-price="$FullTotalPrice.Value">$Controller.activeDate.Price.Nice</strong></td></tr>
							</tbody>
						</table>
					</div>
					<div class="uk-margin">
						<div class="uk-panel uk-background-muted uk-padding-small">
							<h4><%t Event.PaymentType 'Zahlungsart' %></h4>
							<div id="payment-type"></div>
						</div>
					</div>
					<div class="uk-margin">
						<div class="<% if  PaymentMethod == "bill" || PaymentMethod == "online" %>uk-child-width-1-2@s uk-grid-match<% end_if %> uk-grid-small" data-uk-grid>
							<div>
								<div class="uk-panel uk-background-muted uk-padding-small">
									<h4><%t Event.CustomerData 'Ihre Angaben' %></h4>
									<p id="event-address">
									</p>
								</div>
							</div>
						</div>
					</div>

				</div>
				
				<hr>
				
					<div class="uk-text-right">
						<div id="summary-bill-container" class="dk-text-content">
						<% with Fields.FieldByName('SummaryFields') %>
						$FieldHolder
						<% end_with %>
						</div>
						<div id="card-form-container" class="uk-margin" hidden>
							<div class="uk-panel uk-background-muted uk-padding-small uk-text-center">
								<h4><%t Checkout.OnlinePayment 'Online bezahlen' %></h4>
								$Top.SiteConfig.OnlinePayLabel
								<div id="paypal-button-container">
								</div>
							</div>
						</div>
					</div>
				
				<div class="uk-margin uk-flex uk-flex-between">
					<a data-step="backward"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></a>
					<% if $Actions %>
						<% loop $Actions %>
							$Field
						<% end_loop %>
					<% end_if %>
				</div>
				
			</li>

			
		</ul>
	</div>
	<% with Fields.FieldByName('DateID') %>
	$FieldHolder
	<% end_with %>
	<% with Fields.FieldByName('SecurityID') %>
	$FieldHolder
	<% end_with %>

	
<% if $IncludeFormTag %>
</form>
<% end_if %>
