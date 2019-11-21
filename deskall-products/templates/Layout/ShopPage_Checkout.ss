<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-visible@m">
				<% include ProductSidebar %>
			</div>
			<div class="uk-width-3-4@m">
				<div class="uk-margin"><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="fa fa-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div>
				<h1>$Title</h1>
				<% with Product %>
				<%-- <div id="product" data-product-id="$ID" class="uk-child-width-1-1 uk-child-width-1-2@m uk-grid-small" data-uk-grid>
					<div>
						<div class="uk-position-relative" tabindex="-1" data-uk-slideshow="min-height: 350; max-height: 350; animation: fade">

						<ul class="uk-slideshow-items" data-uk-lightbox>
							<% if MainImage.exists %>
							<% with MainImage %>
							<li class="uk-flex uk-flex-middle uk-flex-center">
								<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
									<img data-src="
									<% if $getExtension == "svg" %>
									$URL
									<% else %>
									$Fit(350,350).URL
									<% end_if %>" alt="$Up.AltTag($Description,$Name,$up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img>
								</a>
							</li>
							<% end_with %>
							<% end_if %>
							<% if Images.exists %>
							<% loop Images.sort('SortOrder') %>
							<li class="uk-flex uk-flex-middle uk-flex-center">
								<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
									<img data-src="
									<% if $getExtension == "svg" %>
									$URL
									<% else %>
									$Fit(350,350).URL
									<% end_if %>" alt="$Up.AltTag($Description,$Name,$up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img>
								</a>
							</li>
							<% end_loop %>
							<% end_if %>
							
						</ul>

							<a class="uk-position-center-left uk-position-small uk-dark uk-text-primary" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
							<a class="uk-position-center-right uk-position-small uk-dark uk-text-primary" data-uk-slidenav-next data-uk-slideshow-item="next"></a>

					</div>
					</div>
					<div>
						<h2 class="uk-text-muted">$Title</h2>
						<% if Subtitle %><p>$Subtitle</p><% end_if %>
						<div class="uk-text-muted">$LeadText</div>
					</div>
				</div> --%>
			<%-- 	<div class="uk-margin-large">
					<h3><%t Event.Voucher 'Gutschein' %></h3>
					<p><%t Event.VoucherLabel 'Geben Sie hier Ihre Gutschein-Nr. und klicken Sie an "Gutschein prüfen".' %></p>
					<form class="uk-form uk-form-horizontal" method="post" action="{$Link}VoucherForm" data-form-voucher>
						<input type="text" name="voucher" class="uk-input uk-width-medium" placeholder="<%t Event.VoucherPLH 'zb: A12B3C4D' %>" required />
						<input type="hidden" name="event" value="$Date.ID" />
						<input type="submit" class="uk-button uk-button-primary" value="<%t Event.VoucherCheck 'Gutschein prüfen' %>" />
					</form>
				</div>
				 --%>
				<div class="element" id="product" data-product-id="$ID">
					<div class="uk-background-muted">
						<table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
							<thead><tr><th>Produkt</th><th>Preis</th><th>Menge</th><th>Gesamt</th></tr></thead>
							<tbody>
								<tr>
									<td>$Title</td>
									<td data-price="$currentPrice">
										<% if $currentPrice != $Price %>
										<s>$Price EUR</s><span class="uk-margin-small-left">$DiscountPrice EUR</span>
										<% else %>$Price EUR
										<% end_if %>
									</td>
									<td>
										<% if CanBuyMoreThanOne %>
										<div class="uk-inline">
										    <a class="uk-form-icon uk-form-icon uk-text-muted" data-uk-icon="icon: minus;ratio:0.5" data-less disabled="disabled"></a>
										    <a class="uk-form-icon uk-form-icon-flip uk-text-muted" data-uk-icon="icon: plus;ratio:0.5" data-plus></a>
											<input name="quantity" type="number" min="1" <% if Quantities %>max="$Quantities"<% end_if %> class="uk-input uk-width-small uk-text-center" required value="1" />
										</div>
										<% else %>
										1
										<% end_if %>
									</td>
									<td data-subtotal="$currentPrice" data-price="$currentPrice">$currentPrice EUR</td>
								</tr>
								<% if not Online %>
								<tr>
									<td colspan="3"><%t Product.TransportCost 'Transportkosten (pauschal Preis)' %><% if DeliveryTime %><br/><i class="fa fa-truck uk-margin-small-right"></i><%t Product.DeliveryTime 'Lieferzeit:' %> $DeliveryTime<% end_if %></td>
									
									<td data-subtotal="$getProductConfig.TransportCost">$getProductConfig.TransportCost EUR</td>
								</tr>
								<% end_if %>
							</tbody>
							<tfoot><tr><td colspan="3"><strong><%t Checkout.Total 'Gesamtbetrag' %></strong></td><td id="total-price" data-total=""></td></tr></tfoot>
						</table>
					</div>
				</div>
				<% end_with %>
				
				<% if not loggedIn %>
					<div class="uk-margin">
						<h4><%t Checkout.CustomerAccount 'Kundenkonto' %></h4>
							<div>
								<p><%t Customer.AlreadyCustomer 'Ich habe bereits ein <a data-uk-toggle="target: #login-modal" title="Jetzt einloggen">Kundenkonto</a>' %></p>
							</div>
							<div>
								<form id="customer-email-form" class="uk-grid-small uk-child-width-1-2@s" data-uk-grid>
									<div>
										<input id="customer-email" class="uk-input" type="email" name="email" placeholder="<%t Customer.EmailLabel 'E-Mail-Adresse' %> *" required />
									</div>
									<div>
										<button id="checkout-first-step-button" type="submit" class="uk-button uk-button-primary"><%t Checkout.NextToPayment 'Weiter zu Zahlung' %></button>
									</div>
								</form>
							</div>
						
						<p class="uk-text-small"><strong><%t Customer.WhyCreateCustomer 'Warum muss ich ein Kundenkonto erstellen?' %></strong><br/>
							$ProductConfig.CustomerAccountLabel
						</p>
					</div>
				<% else %>
					<input id="customer-email" type="hidden" name="email" value="$CurrentUser.Email" />
				<% end_if %>
					<div id="payment-form" class="uk-margin" <% if not loggedIn %>hidden="hidden"<% end_if %>>
						<h4><%t Checkout.SecurePayment 'Sichere Zahlung' %></h4>
							<% if Product.Online %>
								<div class="uk-text-small">$ProductConfig.OnlinePayLabel</div>
							    <div id="paypal-button-container" class="uk-width-medium"></div>
							    <hr>
							    <p><i><%t Checkout.OnlineProductOnlinePayment 'Die Zahlung per Rechnung ist für digitale Waren nicht möglich' %></i></p>
							<% else %>
							<p><i><%t Checkout.PaymentMethod 'Wählen Sie Ihre Zahlungsart' %></i></p>
								<ul data-uk-tab>
									<li><a><%t Event.PayOnline 'Online Zahlen (Paypal / Kreditkarte)' %></a></li>
									<li><a><%t Event.PayBill 'Zahlen mit Rechnung' %></a></li>
								</ul>
							
						
							<ul class="uk-switcher uk-margin">
								<li>
							    	<h4><%t Event.PayOnline 'Online Zahlen (Paypal / Kreditkarte)' %></h4>
							    	$ProductConfig.OnlinePayLabel
							    	<div id="paypal-button-container" class="uk-width-medium"></div>
							    </li>
							    <li>
							    	<h4><%t Event.PayBill 'Zahlen mit Rechnung' %></h4>
							    	$ProductConfig.BillPayLabel
							    	$BuyBillForm
							    </li>
							    
							</ul>
							<% end_if %>
					</div>
				
			</div>
		</div>
	</div>
</section>

  <% if not $loggedIn %>
    <div id="login-modal" data-uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" data-uk-close></button>
            <h2 class="uk-modal-title">Jetzt einloggen</h2>
            $OrderLoginForm
        </div>
    </div>
    <% end_if %>