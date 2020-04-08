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
				
				<div id="summary" class="summary-products">
					<div class="uk-panel uk-background-muted uk-padding-small">
						<h4><%t Checkout.SummaryTitle 'Ihre Bestellung' %></h4>
						<table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-table-justify uk-table-responsive">
							<thead><th colspan="2"><%t Webshop.Article 'Artikel' %></th><th class="uk-text-center"><%t Webshop.Quantity 'Menge' %></th><th class="uk-text-right"><%t Webshop.Total 'Gesamtsumme' %></th></thead>
							<tbody class="uk-table-divider">
								<% if Products.exists %>
								<% loop Products.Sort('Sort') %>
								<tr>
									<td><img src="$MainBild.FocusFill(80,80).URL" class="uk-border-circle" /></td>
									<td class="uk-text-truncate uk-table-expand">$Title<br/><%t Webshop.Price 'Stückpreis' %>: $Price.Nice</td><td class="uk-text-center@m">$Quantity</td><td class="uk-text-right">$Subtotal.Nice</td>
								</tr>
								<% end_loop %>
								<% end_if %>
							
							
								<% if Voucher.exists %><tr><td colspan="3" class="uk-text-right"><%t Webshop.Voucher 'Gutschein:' %></td><td id="voucher-price" class="uk-text-right">- $DiscountPrice.Nice</td></tr><% end_if %>
								<tr><td colspan="3" class="uk-text-right"><%t Webshop.MwSt 'Enthaltene Mehrwertsteuer:' %> $SiteConfig.MwSt %</td><td id="total-price" class="uk-text-right">$MwSt.Nice</td></tr>
								<tr><td colspan="3" class="uk-text-right"><strong><%t Webshop.Total 'Gesamtsumme:' %></strong></td><td id="total-price" class="uk-text-right uk-text-bold"><strong>$TotalPrice.Nice</strong></td></tr>
								<tr><td colspan="3" class="uk-text-right"><%t Webshop.Transport 'Porto und Verpackung' %></td><td class="uk-text-right">$TransportPrice.Nice</td></tr>
								<tr class="uk-table-divider"><td colspan="3" class="uk-text-right"><strong><%t Webshop.TotalPrice 'Preis inklusive MwSt., Porto und Verpackung' %></strong></td><td class="uk-text-right"><strong id="full-total-price" data-price="$FullTotalPrice.Value">$FullTotalPrice.Nice</strong></td></tr>
							</tbody>
						</table>
					</div>
					<div class="uk-margin">
						<div class="uk-panel uk-background-muted uk-padding-small">
							<h4><%t Webshop.PaymentType 'Zahlungsart' %></h4>
							$PaymentResource
						</div>
					</div>
					<div class="uk-margin">
						<div class="<% if  PaymentMethod == "bill" || PaymentMethod == "online" %>uk-child-width-1-2@s uk-grid-match<% end_if %> uk-grid-small" data-uk-grid>
							<div>
								<div class="uk-panel uk-background-muted uk-padding-small">
									<h4><% if PaymentMethod == "bill" || PaymentMethod == "online" %><%t Webshop.BillAddressTitle 'Rechnungsadresse' %><% else %><%t Webshop.CustomerData 'Ihre Angaben' %><% end_if %></h4>
									<p><% if Company %>$Company<br/><% end_if %>
										$Gender $FirstName $Name<br/>
										$Email<br/>
										$Phone<br/>
										<% if Street %>$Street<br/><% end_if %>
										<% if Address %>$Address<br/><% end_if %>
										<% if Region %>$Region<br/><% end_if %>
										<% if PostalCode %>$PostalCode -<% end_if %>
										<% if City %>$City<br/><% end_if %>
										<% if Country %>$NiceCountry<br/><% end_if %>
										<% if Address %>$Address<br/><% end_if %>
									</p>
									<% if $Additional %>
									<p>$Additional</p>
									<% end_if %>
								</div>
							</div>
							<% if  PaymentMethod == "bill" || PaymentMethod == "online" %>
							<div>
								<div class="uk-panel uk-background-muted uk-padding-small">
									<h4><%t Webshop.DeliveryAddress 'Lieferadresse' %></h4>
									$printDeliveryAddress
									<h4><%t Webshop.DeliveryConditions 'Lieferbedingungen' %></h4>
									$SiteConfig.DeliveryLabel
								</div>
							</div>
							<% end_if %>
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
