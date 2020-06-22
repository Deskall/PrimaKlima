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
			<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t Shop.ChoosePackage '1. Paket wählen' %></a></li>
			<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t Shop.ChoosePayment '2. Zahlungsmethod' %></a></li>
			<li <% if $activeTab == "payment" %>class="uk-active"<% end_if %>><a><%t Shop.Confirm '3. Bestätigung' %></a></li>
		</ul>
		<ul id="component-tab" class="uk-switcher">
			<li class="account-tab" data-index="0" data-uk-height-match="h3">
				<h3><%t Checkout.ChoosePackage 'Wählen Sie Ihre Paket nach Mass' %></h3>
				<div class="uk-child-width-1-3@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
					<% loop Controller.activePackages %>
					    <div class="dk-transition-toggle-not-mobile">
					    	
					        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative">
						        <% if ClassName == "MatchingToolPackage" %>
						        <h3 class="uk-card-title">$Title</h3>
						        <div class="product-body">
						        	<div class="uk-margin">$CreditsTitle</div>
						        	<% loop $Features %>
						        		<div class="uk-margin">$Title</div>
						        	<% end_loop %>   
							    </div>
						        <div class="product-footer">
						        	<% if PackegeOptions %>
						        	<select name="package-option" class="uk-select">
						        		<% loop PackegeOptions %>
						        		<option value="$ID" data-price="$Price" data-runtime="$Title">$Title $Price €</option>
						        		<% end_loop %>
						        	</select>
						        	<% else %>
						        	<div class="product-price uk-text-large uk-text-bold">$Price €</div>
						        	<% end_if %>
						        	<div class="uk-margin">
						        		<a data-package-choice="$ID" data-price="$Price" data-type="$ClassName" class="uk-button uk-button-primary"><%t Checkout.Order 'Bestellen' %><i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
						        	</div>
						        	<div class="footer-text">$FooterText</div>
						    	</div>
						        <% else %>
						        <h3 class="uk-card-title">$Title</h3>
						        <div class="product-body">
						        	<div class="uk-margin">$RunTimeTitle</div>
						        	<div class="uk-margin">$NumOfAdsTitle</div>
						        	<% loop $Features %>
						        		<div class="uk-margin">$Title</div>
						        	<% end_loop %>   
							    </div>
						        <div class="product-footer">
						        	<% if PackegeOptions %>
						        	<select name="package-option" class="uk-select">
						        		<% loop PackegeOptions %>
						        		<option value="$ID" data-price="$Price" data-runtime="$Title">$Title $Price €</option>
						        		<% end_loop %>
						        	</select>
						        	<% else %>
						        	<div class="product-price uk-text-large uk-text-bold">$Price €</div>
						        	<% end_if %>
						        	<div class="uk-margin">
						        		<a data-package-choice="$ID" data-price="$Price" data-type="$ClassName" class="uk-button uk-button-primary"><%t Checkout.Order 'Bestellen' %><i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
						        	</div>
						        	<div class="footer-text">$FooterText</div>
						    	</div>
						    	<% end_if %>
						    </div>
					    </div>
					<% end_loop %>
				</div>
				<% with Fields.FieldByName('ProductID') %>
				$FieldHolder
				<% end_with %>
				<% with Fields.FieldByName('OptionID') %>
				$FieldHolder
				<% end_with %>
			</li>
			<li class="account-tab" data-index="1">
				<h3><%t Checkout.ChoosePaymentType 'Wählen Sie Ihre Zahlungsmethod' %></h3>
				<div class="uk-margin">
					<div class="uk-child-width-1-2@s" data-uk-grid data-uk-height-match=".uk-card">
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-ios-paper"></i></div>
								<input id="bill-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="bill" required="required"><label for="bill-choice"><%t Shop.BillPayLabel 'Ich bezahle per Rechnung' %></label>
							</div>
						</div>
						<div>
							<div class="uk-card uk-card-body uk-card-default uk-text-center">
								<div class="icon-large"><i class="icon icon-card"></i></div>
								<input id="online-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="online" required="required"><label for="online-choice"><%t Shop.OnlinePayLabel 'Ich bezahle online mit meiner Kreditkarte oder meinem PayPal-Konto' %></label>
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
					<% if ClassName == "MatchingToolPackage" %>
					<div id="summary-package-{$ID}" class="summary-package" hidden>
						<table class="uk-table uk-table-small">
							<thead><th><%t Checkout.SummaryTableTH1 'Paket' %></th><th><%t Checkout.SummaryTableTH3 'Kredite' %></th><th><%t Checkout.SummaryTableTH2 'Preis' %></th></thead>
							<tbody id="package-summary"><tr><td><strong>$Title</strong></td><td>$CreditsTitle</td><td class="price uk-text-bold">$Price €</td></tr></tbody>
						</table>
					</div>
					<% else %>
					<div id="summary-package-{$ID}" class="summary-package" hidden>
						<table class="uk-table uk-table-small">
							<thead><th><%t Checkout.SummaryTableTH1 'Paket' %></th><th><%t Checkout.SummaryTableTH3 'Laufzeit' %></th><th><%t Checkout.SummaryTableTH4 'Anzahl Anzeige' %></th><th><%t Checkout.SummaryTableTH2 'Preis' %></th></thead>
							<tbody id="package-summary"><tr><td><strong>$Title</strong></td><td class="runtime">$RunTimeTitle</td><td>$NumOfAdsTitle</td><td class="price uk-text-bold">$Price €</td></tr></tbody>
						</table>
					</div>
					<% end_if %>
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
