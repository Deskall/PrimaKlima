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
			<li class="account-tab" data-index="0">
				<h3>Wählen Sie Ihre Paket nach Mass</h3>
				<div class="uk-child-width-1-4@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
					<div>
						<div class="uk-card uk-card-body">
							<h3 class="uk-card-title">&nbsp;</h3>
							<div class="product-body uk-text-right">
								<div class="uk-margin"><%t Package.RunTime 'Laufzeit' %></div>
								<div class="uk-margin"><%t Package.OfferQuota 'Anzahl Stelleninserate' %></div>
							    <% loop Controller.activeParameters %>
								<div class="uk-margin">$Title</div>
								<% end_loop %>   	
							</div>
						</div>
					</div>
					<% loop Controller.activePackages %>
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
						        		<a data-step="forward" class="uk-button uk-button-primary">Bestellen</a>
						        	</div>
						        	<div class="footer-text">$FooterText</div>
						    	</div>
						    </div>
					    </div>
					<% end_loop %>
				</div>
				<% with Fields.FieldByName('PackageID') %>
				$FieldHolder
				<% end_with %>
			</li>
			<li class="account-tab" data-index="1">
				<h3>Wählen Sie Ihre Zahlungsmethod</h3>
				<div class="uk-margin">
					<div class="uk-child-width-1-2@s" data-uk-grid>
						<div>
							<input id="bill-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="bill"><label for="bill-choice"><%t Shop.BillPayLabel 'Ich zahle mit Rechnung' %></label>
						</div>
						<div>
							<input id="online-choice" class="uk-radio uk-margin-right" type="radio" name="paymentmethod" value="bill"><label for="online-choice"><%t Shop.BillPayLabel 'Ich zahle Online mit Kredit Kard oder meinem paypal Konto' %></label>
						</div>
					</div>
				</div>
				<div id="bill-form-container" class="uk-margin" >
					<div class="uk-panel uk-background-muted uk-padding-small">
						<h4>Rechnungsadresse</h4>
						<% with Fields.FieldByName('BillFields') %>
							$FieldHolder
						<% end_with %>
					</div>
				</div>
				<div class="uk-flex uk-flex-between">
					<a class="uk-button uk-button-muted" data-step="backward"><%t Global.Back 'Zurück' %></a>
					<a class="uk-button uk-button-primary" data-step="forward"><%t Global.Forward 'Weiter' %></a>
				</div>
			</li>
			<li class="account-tab" data-index="2">
				<h3>Prüfen und bestätigen Sie Ihre Bestellung</h3>
				<div class="uk-panel uk-background-muted uk-padding-small">
					<% with Fields.FieldByName('SummaryFields') %>
					$FieldHolder
					<% end_with %>
					<div id="paypal-button-container"></div>
				</div>
				<div class="uk-flex uk-flex-between">
					<a class="uk-button uk-button-muted" data-step="backward"><%t Global.Back 'Zurück' %></a>
					<% if $Actions %>
						<% loop $Actions %>
							$Field
						<% end_loop %>
					<% end_if %>
				</div>
				
			</li>
		</ul>
	</div>

	<% with Fields.FieldByName('SecurityID') %>
	$FieldHolder
	<% end_with %>

	
<% if $IncludeFormTag %>
</form>
<% end_if %>
