$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<div class="uk-container">
		<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
			<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t Shop.ChoosePackage '1. Paket wählen' %></a></li>
			<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t Shop.ChoosePayment '2. Zahlungsmethod' %></a></li>
			<li <% if $activeTab == "payment" %>class="uk-active"<% end_if %>><a><%t Shop.Confirm '3. Bestätigung' %></a></li>
		</ul>
		<ul id="component-tab" class="uk-switcher">
			<li class="account-tab">
				<h3>Wählen Sie Ihre Paket nach Mass</h3>
				<div class="uk-child-width-1-4@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
					<div>
						<div class="uk-card uk-card-body">
							<h3 class="uk-card-title">&nbsp;</h3>
							<div class="product-body uk-text-right">
								<div class="uk-margin"><%t Package.RunTime 'Laufzeit' %></div>
								<div class="uk-margin"><%t Package.OfferQuota 'Anzahl Stelleninserate' %></div>
							    <% loop activeParameters %>
								<div class="uk-margin">$Title</div>
								<% end_loop %>   	
							</div>
						</div>
					</div>
					<% loop activePackages %>
					    <div class="dk-transition-toggle-not-mobile">
					    	
					        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative">
						        
						        <h3 class="uk-card-title">$Title</h3>
						        <div class="product-body">
						        	<div class="uk-margin">$RunTimeTitle</div>
						        	<div class="uk-margin">$NumOfAdsTitle</div>
						        	<% loop $Parameters %>
						        	<% if included %>
						        	<div class="uk-margin"><i class="icon icon-checkmark"></i></div>
						        	<% else %>
						        	<div class="uk-margin">-</div>
						        	<% end_if %>
						        	<% end_loop %>   
							    </div>
						        <div class="product-footer">
						        	<% if PackegeOptions %>
						        	<select name="package-option" class="uk-select">
						        		<% loop PackegeOptions %>
						        		<option value="$ID">$Title $Price €</option>
						        		<% end_loop %>
						        	</select>
						        	<% else %>
						        	<div class="product-price uk-text-large uk-text-bold">$Price €</div>
						        	<% end_if %>
						        	<div class="uk-margin">
						        		<a href="$OrderLink" class="uk-button btn-order">Bestellen</a>
						        	</div>
						        	<div class="footer-text">$FooterText</div>
						    	</div>
						    </div>
					    </div>
					<% end_loop %>
				</div>
			</li>
			<li class="account-tab">
				<h3>Wählen Sie Ihre Zahlungsmethod</h3>
				<div class="uk-margin">
					<div class="uk-child-width-1-2@s" data-uk-grid>
						<div>
							<label class="uk-button uk-button-primary"><input class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="bill"><%t Shop.BillPayLabel 'Ich zahle mit Rechnung' %></label>
						</div>
						<div>
							<label class="uk-button uk-button-primary"><input class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="bill"><%t Shop.BillPayLabel 'Ich zahle Online mit Kredit Kard oder meinem paypal Konto' %></label>
						</div>
					</div>
				</div>
			</li>
			<li class="account-tab">
				<h3>Prüfen und bestätigen Sie Ihre Bestellung</h3>
				<div id="paypal-button-container"></div>
			</li>
		</ul>
	</div>
</section>
