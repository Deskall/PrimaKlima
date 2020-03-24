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
			<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t Shop.ShopCart '1. Warenkorb' %></a></li>
			<% if Controller.activeCart.products.exists %>
			<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t Shop.ChoosePayment '3. Zahlungsmethod' %></a></li>
			<li <% if $activeTab == "payment" %>class="uk-active"<% end_if %>><a><%t Shop.Confirm '4. Bestätigung' %></a></li>
			<% end_if %>
		</ul>
		<ul id="component-tab" class="uk-switcher">
			<li class="account-tab" data-index="0">
				<h3><%t Checkout.ShopCartTitle 'Ihr Warenkorb' %></h3>
					<% with Controller.activeCart %>
					<div class="order-preview">
					   <% include ShopCartCheckout %>
					</div>
					<% end_with %>
					<div class="uk-flex uk-flex-between">
						<a class="uk-button uk-button-muted" data-step="backward"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></a>
						<a class="uk-button uk-button-primary" data-step="forward"><%t Global.Forward 'Weiter' %><i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
					</div>
			</li>
			<% if Controller.activeCart.products.exists %>
			<li class="account-tab" data-index="1">
				<h3><%t Checkout.ChoosePaymentType 'Wählen Sie Ihre Zahlungsmethod' %></h3>
				<div class="uk-margin">
					<div class="uk-child-width-1-3@s" data-uk-grid data-uk-height-match=".uk-card">
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-ios-money"></i></div>
								<input id="cash-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="cash" required="required"><label for="cash-choice"><%t Shop.CashPayLabel 'Bargeld' %></label>
								<div class="uk-margin">
									Kosten für Porto und Verpackung CHF 9.80
								</div>
							</div>
						</div>
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-ios-paper"></i></div>
								<input id="bill-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="bill" required="required"><label for="bill-choice"><%t Shop.BillPayLabel 'Ich bezahle per Rechnung' %></label>
								<div class="uk-margin">
									Kosten für Porto und Verpackung CHF 9.80
								</div>
							</div>
						</div>
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-card"></i></div>
								<input id="online-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="online" required="required"><label for="online-choice"><%t Shop.OnlinePayLabel 'Ich bezahle online mit meiner Kreditkarte oder meinem PayPal-Konto' %></label>
								<div class="uk-margin">
									Kosten für Porto und Verpackung CHF 9.80
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="bill-form-container" class="uk-margin" hidden>
					<div class="uk-panel uk-background-muted uk-padding-small">
						<h4><%t Checkout.BillAddress 'Rechnungsadresse' %></h4>
						$SiteConfig.BillPayLabel
						<% with Fields.FieldByName('BillFields') %>
							$FieldHolder
						<% end_with %>
					</div>
				</div>
				<div class="uk-flex uk-flex-between">
					<a class="uk-button uk-button-muted" data-step="backward"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></a>
					<a class="uk-button uk-button-primary" data-step="forward"><%t Global.Forward 'Weiter' %><i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
				</div>
				<% with Fields.FieldByName('PaymentType') %>
				$FieldHolder
				<% end_with %>
			</li>
			<li class="account-tab" data-index="2">
				<h3><%t Checkout.ReviewAndPay 'Prüfen und bestätigen Sie Ihre Bestellung' %></h3>
				<div class="uk-panel uk-background-muted uk-padding-small">
					<h3><%t Checkout.Voucher 'Gutschein' %></h3>
					<p><%t Checkout.VoucherLabel 'Geben Sie hier Ihre Gutschein-Nr. und klicken Sie an "Gutschein prüfen".' %></p>
					<div class="uk-flex uk-flex-left">
						<div class=" uk-width-medium uk-margin-small-right"><input type="text" name="voucher" class="uk-input" minlength="10" maxlength="10" placeholder="<%t Checkout.VoucherPLH 'zb: A12B3C4DEF' %>" /></div>
						<a class="uk-button uk-button-primary" data-check-voucher><%t Checkout.VoucherCheck 'Gutschein prüfen' %></a>
					</div>
				</div>
				<hr>
				<div class="uk-panel uk-background-muted uk-padding-small">
					<h4><%t Checkout.SummaryTitle 'Ihre Bestellung' %></h4>
					<% loop Controller.activePackages %>
					<div id="summary-package-{$ID}" class="summary-package" hidden>
						<table class="uk-table uk-table-small">
							<thead><th><%t Checkout.SummaryTableTH1 'Paket' %></th><th><%t Checkout.SummaryTableTH3 'Laufzeit' %></th><th><%t Checkout.SummaryTableTH4 'Anzahl Anzeige' %></th><th><%t Checkout.SummaryTableTH2 'Preis' %></th></thead>
							<tbody id="package-summary"><tr><td><strong>$Title</strong></td><td class="runtime">$RunTimeTitle</td><td>$NumOfAdsTitle</td><td class="price uk-text-bold">$Price €</td></tr></tbody>
						</table>
					</div>

					<% end_loop %>
				</div>
				<hr>
				
					<div class="uk-text-right">
						<div id="summary-bill-container">
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
					<a class="uk-button uk-button-muted" data-step="backward"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i><%t Global.Back 'Zurück' %></a>
					<% if $Actions %>
						<% loop $Actions %>
							$Field
						<% end_loop %>
					<% end_if %>
				</div>
				
			</li>

			<% end_if %>
		</ul>
	</div>
	<% with Fields.FieldByName('CustomerID') %>
	$FieldHolder
	<% end_with %>
	<% with Fields.FieldByName('VoucherID') %>
	$FieldHolder
	<% end_with %>
	<% with Fields.FieldByName('SecurityID') %>
	$FieldHolder
	<% end_with %>

	
<% if $IncludeFormTag %>
</form>
<% end_if %>
