<div class="dk-text-content">
    $HTML
</div>


    <div id="loading-block" class="uk-flex-middle"><p><span data-uk-spinner class="uk-margin-right"></span>Bitte warten Sie einen Moment, das Formular wird geladen.</p></div>
    <div id="order-form-content" class="dk-hidden">
        <form id="order-form" method="post" action="{$getPage.Link}SendOrderForm">
            <ul id="pellets-order-container" class="bestellung-container" data-uk-accordion data-config='$getConfigJson'>
                <li class="uk-open" data-step="need" data-requests="$getPage.getRemainingRequests">
                    <div class="uk-accordion-title">Bedarf</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                        	<%--     <div class="uk-width-1-1"><strong>Mein Lieferobjekt (PLZ) *</strong></div> --%>
                               
                        		<div class="uk-width-1-1"><strong>Liefermenge</strong></div>
                         		<div class="uk-width-1-3@s uk-margin-bottom">
                                        <label class="uk-form-label">Menge in Tonnen:</label><%-- <span id="quantity_preview" class="uk-margin-small-left"></span> --%>
                                        <input id="quantity_custom" class="uk-input uk-form-width-small" type="number" name="PelletsQuantityCustom" min="0.5" step="0.5" value="<% if $Controller.StoredData.PelletsQuantityCustom %>$Controller.StoredData.PelletsQuantityCustom<% else %>5<% end_if %>" data-field="#quantity_range" data-name="PelletsQuantity" />
                                </div>
                                <div class="uk-width-2-3@s ">
                         			<div class="pellets-jauge uk-flex uk-flex-middle uk-text-center">
                         			<img src="<% if PelletsImage.getExtension == "svg" %>$PelletsImage.URL<% else %>$PelletsImage.ScaleHeight(200).URL<% end_if %>" alt="$PelletsImage.AltTag($Title)" title="$PelletsImage.TitleTag($Title)" width="250" height="200">
                         			</div>
                         			<input id="quantity_range" class="uk-range pellets-range" type="range" name="PelletsQuantityRange" min="0.5" max="24" step="0.5" data-field="#quantity_custom" value="<% if $Controller.StoredData.PelletsQuantityRange %>$Controller.StoredData.PelletsQuantityRange<% else %><% if getCustomerData %>$getCustomerData.PelletsQuantity<% else %>5<% end_if %><% end_if %>" data-name="PelletsQuantity">
                         		</div>
                         		<div id="big-quantity-message" class="uk-width-1-1 dk-hidden">
                                    <div class="uk-padding uk-padding-remove-horizontal">
                                        <p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="warning"></span>Bei Liefermengen von mehr als 24 Tonnen können wir Ihnen ein individuelles Angebot zu Spezialkonditionen zustellen.<br/>Bitte kontaktieren Sie uns.</p>
                                        <a href="$ContactLink" class="uk-button uk-button-primary" title="mehr als 24 Tonnen bestellen" data-uk-icon="icon: file-edit;">Kontakt aufnehmen</a>
                                    </div>
                                </div>

                         		<div class="uk-width-1-1"><strong>Jahresbedarf</strong></div>
                                <div class="uk-width-1-1 uk-width-1-2@s"><p>Liegt ihr Jahresbedarf an Holzpellets über 20 Tonnen?</p></div>
                                <div class="uk-width-1-2 uk-width-1-4@s">
                                    <label class="uk-form-label"><input type="radio" class=" uk-margin-small-right" name="YearQuantity" value="1" <% if $Controller.StoredData.YearQuantity == 1 %>checked<% end_if %> />Ja</label>
                                </div>
                                <div class="uk-width-1-2 uk-width-1-4@s">
                                    <label class="uk-form-label"><input type="radio" class=" uk-margin-small-right" name="YearQuantity" value="0" <% if $Controller.StoredData.YearQuantity != 1 %>checked<% end_if %> />Nein</label>
                                </div>
                                <div id="big-year-quantity-message" class="uk-width-1-1" hidden>
                                    <div class="uk-padding uk-padding-remove-horizontal">
                                        <p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="warning"></span>Bitte Kontaktieren Sie uns, so können wir Ihnen ein individuelles Angebot zu Spezialkonditionen zustellen.</p>
                                        <a class="uk-button uk-button-primary" title="Komtakt aufnehmen" data-uk-icon="icon: file-edit;">Kontakt aufnehmen</a>
                            		</div>
                                </div>
                                <input name="PelletsQuantity" type="hidden" data-message="#big-quantity-message" data-max-value="24" />
                                <div class="uk-width-1-1"><strong>Lieferort</strong></div>
                                <div class="uk-width-1-1"><p>Bitte geben Sie die Postleitzahl des Lieferortes an, um den richtigen Preis pro Tonne inklusive Transportkosten berechnen zu können.</p></div>
                                <div class="uk-width-1-2@m"><input name="postalcode" type="text" autocomplete="off" class="uk-input uk-form-width-medium" required="required" placeholder="PLZ *" value="<% if $Controller.StoredData.postalcode %>$Controller.StoredData.postalcode<% else %><% if getCustomerData %>$getCustomerData.postalcode<% else %><% end_if %><% end_if %>" /><button id="get-price" class="uk-button uk-button-primary" data-target="products">Preis berechnen</button></div>
                                
                        </div>
                    </div>       
                </li>
                <li data-step="products">
                    <div class="uk-accordion-title">Preise</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		<div class="uk-width-1-2@s">
                        			<div><strong>AEK Pellets</strong></div>
                                    <div>
                                    <img src="<% if PelletsImage.getExtension == "svg" %>$PelletsImage.URL<% else %>$PelletsImage.FocusFill(250,200).URL<% end_if %>" alt="$PelletsImage.AltTag($Title)" title="$PelletsImage.TitleTag($Title)" width="250" height="200" ></div>
                        			<div class="dk-text-content">$AEKPelletsHTML</div>
                        			<p><strong>Preis pro Tonne : <strong id="single-price-container"></strong></strong><br/>inkl. 7.7% MwSt.</p>
                                    <p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="warning"></span>dieser Preis ist gültig für <strong id="quantity-print"></strong> <strong>Tonnen</strong> geliefert nach <strong id="location-print"></strong></p>
                         		</div>

                         		<div class="uk-width-1-2@s">
                        			<div><strong>pelprotec Pellets</strong></div>
                                    <div><img src="<% if PelProTecImage.getExtension == "svg" %>$PelProTecImage.URL<% else %>$PelProTecImage.FocusFill(250,200).URL<% end_if %>" alt="$PelProTecImage.AltTag($Title)" title="$PelProTecImage.TitleTag($Title)" width="250" height="200" ></div>
                        			<div class="dk-text-content">$PelProTecHTML</div>
                                    <p><strong>Aufpreis pro Tonne : $printPrice($getConfig.data.pelprotec_preis)</strong><br/>inkl. 7.7% MwSt.</p>
                        			<input id="pelprotec-pellets" type="checkbox" name="PelProTect" class="" <% if $Controller.StoredData.PelProTect == "on" %>checked<% else_if $Controller.StoredData.PelProTect =="off" %><% else %><% if getCustomerData %><% if getCustomerData.PelProTect %>checked<% end_if %><% else %>checked<% end_if %><% end_if %> /><label for="pelprotec-pellets" class="uk-form-label uk-margin-small-left">Ja, ich möchte meine Pellets mit pelprotec versiegeln.</label>
                         		</div>
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="need">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="delivery">Weiter</a>
            	        </div>
                    </div>
                </li>
                <li data-step="delivery">
                    <div class="uk-accordion-title">Lieferung</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-middle" data-uk-grid>
                        		<div class="uk-width-1-1">
                        			<strong>Gewünschter Lieferzeitraum</strong>
                        			<p>Wählen Sie den gewünschten Zeitraum Ihrer Lieferung aus.</p>
                        			<input id="delivery-date" type="text" name="DeliveryPeriod" class="uk-input" required="required" 
                                    value="<% if $Controller.StoredData.DeliveryPeriod %>$Controller.StoredData.DeliveryPeriod<% end_if %>" />
                                    <%-- <label class="uk-form-label">Zuschlag :<span id="delivery-cost_preview" class="uk-margin-small-left">CHF 0.-</span></label> --%>
                        			<input type="hidden" name="fix-termin" value="$Controller.StoredData.fix-termin" />
                                    <input type="hidden" name="speed-termin" value="$Controller.StoredData.speed-termin" />
                         		</div>
                                <div class="uk-width-1-1">
                                    <div id="fix-termin-message" class="dk-hidden uk-margin-small-top"><p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="info"></span>Bei einem Fixtermin (1 Tag) müssen wir einen Zuschlag von $printPrice($getConfig.data.fix_termin_preis) verrechnen.</p></div>
                                    <div id="express-delivery-message" class="dk-hidden"><p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="info"></span>Bei Expresslieferungen (innert 3 Arbeitstagen) müssen wir einen Zuschlag von $printPrice($getConfig.data.schnell_lieferung_preis) verrechnen.</p></div>
                                </div>

                         		<div class="uk-width-1-1 dk-text-content">
                        			<strong>Abladestellen Auswahl</strong><a data-uk-toggle="target: #unload-modal" class="uk-margin-small-left"><span data-uk-icon="info" class="uk-margin-small-right"></span>Welche Art von Abladung passt zu mir?</a>
                        		</div>
                        		<div class="uk-width-1-3@s">
                        			<input id="DeliveryType-1" class="" type="radio" name="DeliveryType" data-cost="0" value="0" <% if $Controller.StoredData.DeliveryType == "0" %>checked<% else %><% if not getCustomerData || getCustomerData.DeliveryType == "0" %>checked<% end_if %><% end_if %>><label for="DeliveryType-1" class="uk-form-label uk-margin-small-left">normaler Ablad</label>
                         		</div>
                         		<div class="uk-width-1-3@s">
                        			<input id="DeliveryType-2" class="" type="radio" name="DeliveryType" data-cost="80" value="1" <% if $Controller.StoredData.DeliveryType == "1" %>checked<% else %><% if getCustomerData && getCustomerData.DeliveryType == "1"%>checked<% end_if %><% end_if %>><label for="DeliveryType-2" class="uk-form-label uk-margin-small-left">aufwändiger Ablad</label>
                         		</div>
                         		<div class="uk-width-1-3@s">
                        			<input id="DeliveryType-3" class="" type="radio" name="DeliveryType" data-cost="100" value="2"  <% if $Controller.StoredData.DeliveryType == "2" %>checked<% else %><% if getCustomerData && getCustomerData.DeliveryType == "2" %>checked<% end_if %><% end_if %>><label for="DeliveryType-3" class="uk-form-label uk-margin-small-left">erschwerter Ablad</label>
                         		</div>
                         		<div class="uk-width-1-1">
                         			<%-- <label class="uk-form-label">Zuschlag :<span id="unload-cost_preview" class="uk-margin-small-left">CHF 0.-</span></label> --%>
                                     <div id="ablad-aufwandig-message" class="dk-hidden uk-margin-small-top"><p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="info"></span>Bei einem aufwändigen Ablad müssen wir einen Zuschlag von $printPrice($getConfig.data.ablad_aufwandig) verrechnen.</p></div>
                                    <div id="ablad-erschwert-message" class="dk-hidden uk-margin-small-top"><p class="uk-padding-small uk-background-muted"><span class="uk-margin-small-right" data-uk-icon="info"></span>Bei einem aufwändigen Ablad müssen wir einen Zuschlag von $printPrice($getConfig.data.ablad_erschwert) verrechnen.</p></div>
                         		</div>
                                <div id="unload-modal" data-uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body">
                                            <h2 class="uk-modal-title">Abladestellen Auswahl</h2>
                                            <div class="dk-text-content">$AbladsHTML</div>
                                            <p class="uk-text-right">
                                                <button class="uk-button uk-button-primary uk-modal-close" type="button">Schliessen</button>
                                            </p>
                                        </div>
                                </div>
                                <div class="uk-width-1-1">
                                    <input id="platform"  type="checkbox" name="DeliveryPlatform"  <% if getCustomerData && getCustomerData.DeliveryPlatform == "1"%>checked<% end_if %>><label for="platform" class="uk-form-label uk-margin-small-left">Zufahrt mit Sattelschlepper möglich <a data-uk-toggle="target: #platform-modal" class="uk-margin-small-left"><span data-uk-icon="info" class="uk-margin-small-right"></span></a></label>
                                </div>
                                <div id="platform-modal" data-uk-modal>
                                    <div class="uk-modal-dialog uk-modal-body">
                                            <h2 class="uk-modal-title">Zufahrt mit Sattelschlepper</h2>
                                            <% if PlatformImage %><div><img src="<% if PlatformImage.getExtension == "svg" %>$PlatformImage.URL<% else %>$PlatformImage.ScaleHeight(200).URL<% end_if %>" alt="$PlatformImage.AltTag($Title)" title="$PlatformImage.TitleTag($Title)" width="250" height="200" ></div><% end_if %>
                                            <div class="dk-text-content">$PlatformHTML</div>
                                            <p class="uk-text-right">
                                                <button class="uk-button uk-button-primary uk-modal-close" type="button">Schliessen</button>
                                            </p>
                                        </div>
                                </div>
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="products">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#"<% if Controller.isLoggedIn %>data-target="bill"<% else %>data-target="login"<% end_if %>>Weiter</a>
            	        </div>
                    </div>
                </li>
                <% if not Controller.isLoggedIn %>
                <li data-step="login">
                        <div class="uk-accordion-title">Konto</div>
                        <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                                <p><strong>Ihre Logindaten</strong></p>
                                <div class="dk-text-content">$LoginHTML</div>
                                <div class="uk-grid-small uk-flex uk-flex-middle" data-uk-grid>
                                    <% if $Controller.isLoggedIn %>
                                    <div class="uk-width-1-1">
                                        <div class="uk-clearfix"><div class="uk-float-left"><p>Sie sind als $Controller.isLoggedIn.username eingeloggt.</p></div>
                                        <a href="{$getPage.Link}CustomerLogOut?BackURL={$getPage.Link.URLATT}" title="abmelden" class="uk-button uk-button-default uk-float-right">Abmelden</a></div>
                                    </div>
                                    <% else %>
                                    <div class="uk-width-1-3@s">
                                        <input id="login-daten-1" class="" type="radio" name="login-daten" value="0" required="required"><label for="login-daten-1" class="uk-form-label uk-margin-small-left">Ich habe bereits ein Konto</label>
                                    </div>
                                    <div class="uk-width-1-3@s">
                                        <input id="login-daten-2" class="" type="radio" name="login-daten" value="1" required="required"><label for="login-daten-2" class="uk-form-label uk-margin-small-left">Neu-Registrierung</label>
                                    </div>
                                    <div class="uk-width-1-3@s">
                                        <input id="login-daten-3" class="" type="radio" name="login-daten" value="2" required="required"><label for="login-daten-3" class="uk-form-label uk-margin-small-left">ohne Registrierung bestellen</label>
                                    </div>
                                    <% end_if %>
                                </div>
                                <div id="login-fields" class="uk-switcher uk-margin" >
                                    <div class="uk-width-1-1 customer-fields">
                                        <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #login-modal">Einloggen</button>
                                    </div>
                                    <div class="uk-width-1-1 customer-fields">
                                        <input type="email" name="Email" class="uk-input uk-margin-small" placeholder="E-Mail-Adresse *" data-required />
                                        <input type="password" name="Password" class="uk-input uk-margin-small" placeholder="Passwort *" data-required />
                                        <input type="password" name="password_2" class="uk-input uk-margin-small" placeholder="Passwort wiederholen *"  data-required data-check-unicity="Password" />
                                    </div>
                                    <div></div>
                                </div>
                                <div class="uk-margin-small uk-align-right">
                                    <a class="step backwards uk-button uk-button-muted" href="#" data-target="delivery">Zurück</a>
                                    <a class="step uk-button uk-button-primary" href="#" data-target="bill">Weiter</a>
                                </div>
                        </div>
                </li>
                <% end_if %>
                <li data-step="bill">
                    <div class="uk-accordion-title">Rechnungsadresse</div>
                   	<div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	<div class="uk-width-1-3@s">
                        		<select class="uk-select uk-form-width-auto" name="BillTitle">
                        			<option value="">Anrede</option>
                        			<option value="Frau" <% if getCustomerData.BillTitle =="Frau" %>selected<% end_if %>>Frau</option>
                        			<option value="Herr"  <% if getCustomerData.BillTitle =="Herr" %>selected<% end_if %>>Herr</option>
                        		</select>
                        	</div>
                        	<div class="uk-width-1-3@s">
                        		<input type="text" class="uk-input" name="BillName" placeholder="Name *" required="required" value="$getCustomerData.BillName" />
                        	</div>
                        	<div class="uk-width-1-3@s">
                        		<input type="text" class="uk-input" name="BillFirstName" placeholder="Vorname *" required="required" value="$getCustomerData.BillFirstName" />
                        	</div>
                        	<div class="uk-width-1-2@s">
                        		<input type="text" class="uk-input" name="BillFirm" placeholder="Firma" value="$getCustomerData.BillFirm" />
                        	</div>
                        	<div class="uk-width-1-2@s">
                        		<input type="text" class="uk-input" name="BillAddOn" placeholder="Zusatz" value="$getCustomerData.BillAddOn" />
                        	</div>
                        	<div class="uk-width-1-1">
                        		<input type="text" class="uk-input" name="BillStreet" placeholder="Strasse *" required="required" value="$getCustomerData.BillStreet" />
                        	</div>
                        	<div class="uk-width-1-4@s">
                        		<input type="text" class="uk-input" name="BillPostalCode" placeholder="PLZ *" required="required" value="$getCustomerData.BillPostalCode" data-linked-field="BillPlace" />
                        	</div>
                        	<div class="uk-width-3-4@s">
                        		<select type="text" class="uk-select" name="BillPlace" required="required">
                                    <option value='' data-keep>Ortschaft auswählen</option>
                                    <% if $getCustomerData.BillPlace %>
                                    <option value='$getCustomerData.BillPlace' selected>$getCustomerData.BillPlace</option>
                                    <% end_if %>
                                </select>
                        	</div>
                        	<div class="uk-width-1-2@s">
                        		<input type="email" class="uk-input" name="BillEmail" placeholder="E-Mail-Adresse *" required="required" value="$getCustomerData.BillEmail" />
                        	</div>
                        	<div class="uk-width-1-2@s">
                        		<input type="text" class="uk-input" name="BillPhone" placeholder="Telefon *" required="required" value="$getCustomerData.BillPhone" data-phone-number="true" />
                        	</div>
                        	<div class="uk-width-1-2@s">
                        		<input type="text" class="uk-input" name="BillMobile" placeholder="Mobile" value="$getCustomerData.BillMobile" data-phone-number="true" />
                        	</div>
                        	<div class="uk-width-1-2@s">
                        		<input type="text" class="uk-input" name="BillFax" placeholder="Fax"  value="$getCustomerData.BillFax" data-phone-number="true"/>
                        	</div>
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" <% if Controller.isLoggedIn %>data-target="delivery"<% else %>data-target="login"<% end_if %>>Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="bill-address">Weiter</a>
            	        </div>
                    </div>
                </li>
                <li data-step="bill-address">
                    <div class="uk-accordion-title">Lieferadresse</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                    	<div class="uk-grid-small" data-uk-grid>
                    		<div class="uk-width-1-1">
            		            <p><strong>Lieferadresse</strong></p>
            		        	<div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
            		            	<div class="uk-width-1-2@s">
            		        			<input id="delivery-address-1" class="" type="radio" name="DeliverySameAsBill" value="1" <% if getCustomerData.DeliverySameAsBill == "1" %>checked<% end_if %>><label for="delivery-address-1" class="uk-form-label uk-margin-small-left">Identisch mit Rechnungsadresse</label>
            		         		</div>
            		         		<div class="uk-width-1-2@s">
            		        			<input id="delivery-address-2" class="" type="radio" name="DeliverySameAsBill" value="0" <% if getCustomerData.DeliverySameAsBill == "0" %>checked<% end_if %>><label for="delivery-address-2" class="uk-form-label uk-margin-small-left">Andere Adresse</label>
            		         		</div>
            		         		
            		         	</div>
            		         	<div id="delivery-address-fields" class="uk-switcher uk-margin" >
            		        		<div id="not-same" class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
            	        				<div class="uk-width-1-1 uk-margin-small">
            			            		<input type="text" class="uk-input" name="DeliveryStreet" placeholder="Strasse *" data-required value="$getCustomerData.DeliveryStreet" />
            			            	</div>
                                        <div class="uk-width-1-1 uk-margin-small">
                                            <input type="text" class="uk-input" name="DeliveryAddOn" placeholder="Zusatz" value="$getCustomerData.DeliveryAddOn" />
                                        </div>
                                       
            			            	<div class="uk-width-1-4@s uk-margin-small">
            			            		<input type="text" class="uk-input" name="DeliveryPostalCode" placeholder="PLZ *" data-required value="$getCustomerData.DeliveryPostalCode" data-linked-field="DeliveryPlace"/>
            			            	</div>
            			            	<div class="uk-width-3-4@s uk-margin-small">
            			            		<input type="text" class="uk-input" name="DeliveryPlace" placeholder="Ort *" data-required value="$getCustomerData.DeliveryPlace" />
            			            	</div>
            			    
            			            	<div class="uk-width-1-2@s uk-margin-small">
            						        <a class="uk-button uk-button-primary check-address" href="#" ><span data-uk-icon="location" class="uk-margin-small-right"></span>Adresse prüfen</a>
            						    </div>
            			            </div>
                                    <div id="same" class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                      <%--                   <div class="uk-width-1-1">
                                            <input type="text" class="uk-input" name="DeliveryPhone" placeholder="Telefonnummer für Anvisierung  (falls abweichend von angegebene Telefonnummer)" data-phone-number="true" />
                                        </div> --%>
                                    </div>
            		        	</div>
            		        </div>
            		        <div class="uk-width-1-1">
            		        	<p><strong>Lieferung Anvisirungs-Nummer</strong></p>
            		        	<p>Auf welche Nummer sind Sie am besten erreichbar?</p>
            		        	<div id="existing-numbers" class="uk-grid-small" data-uk-grid>
            		        		<div class="uk-width-1-3@s">
            		        			<input id="use-phone-bill" class="" type="radio" name="use-phone" value="bill" disabled="disabled" required="required" /><label for="use-phone-bill" class="uk-form-label uk-margin-small-left">Telefon: <span id="phone-number-preview">keine</span></label>
            		        		</div>
            		        		<div class="uk-width-1-3@s">
            		        			<input id="use-phone-mobile" class="" type="radio"  name="use-phone" value="mobile" disabled="disabled" required="required" /><label for="use-phone-mobile" class="uk-form-label uk-margin-small-left">Mobile: <span id="mobile-number-preview">keine</span></label>
            		        		</div>
            		        		<div class="uk-width-1-3@s">
            		        			<input id="use-phone-other" class="" type="radio"  name="use-phone" value="other" required="required" /><label for="use-phone-other" class="uk-form-label uk-margin-small-left">Andere Nummer benutzen</label>
            		        		</div>
            		        	</div>
            		        	<div id="other-number" class="dk-hidden">
            		        		<div class="uk-grid-small uk-margin-small-top" data-uk-grid>
            		        			<div class="uk-width-1-2@s">
        	    		        			<input type="text" class="uk-input" name="DeliveryPhoneDescription" placeholder="Kontatperson (zb. Nachbarn, Hauswart, usw.)" data-required />
        	    		        		</div>
        	    		        		<div class="uk-width-1-2@s">
        	    		        			<input type="text" class="uk-input" name="DeliveryPhone" placeholder="Telefonnummer" data-phone-number="true" data-required />
        	    		        		</div>
        	    		        	</div>
            		        	</div>
            		        </div>
            		        <div class="uk-width-1-1">
            		        	<p><strong>Abladestandort</strong></p>
                                <p id="no-delivery-address">Bitte geben Sie zuerst Ihre Lieferadresse an.</p>
            		        	<div id="with-delivery-address" class="dk-text-content dk-hidden">$LieferungsHTML</div>
                                <p id="delivery-coord" class="dk-hidden SecondaryBackground uk-padding-small">Keine Abladestandort</p>
            		        	<div id="googlemap_delivery-places" class="google-map uk-height-medium"></div>
                                <input type="hidden" name="DeliveryLatitude" data-message-container="#delivery-coord" <% if getCustomerData %>value="$getCustomerData.DeliveryLatitude"<% end_if %> />
                                <input type="hidden" name="DeliveryLongitude" data-message-container="#delivery-coord" <% if getCustomerData %>value="$getCustomerData.DeliveryLongitude"<% end_if %>/>
                        	</div>
                            <div class="uk-width-1-1">
                                <p><strong>Bemerkungen</strong></p>
                                <textarea name="DeliveryComments" class="uk-textarea" placeholder="Bemerkungen für spezielle Zufahrtsbeschränkungen, zur Befüllung usw" <% if getCustomerData %>value="$getCustomerData.DeliveryComments"<% end_if %> rows="10"></textarea>
                            </div>
                        </div>
                       
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="bill">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="review">Weiter</a>
            	        </div>
                    </div>
                </li>
                <li data-step="review">
                    <div class="uk-accordion-title">Bestellen</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        <div class="dk-text-content">$ReviewHTML</div>
                        <input type="hidden" name="OrderHTML" />
                        <input type="hidden" name='BlockID' value="$ID" />
                        <input type="hidden" name='BlockClass' value="$ClassName" />
                        <div id="summary-order">
                            <strong>Bestellung</strong>
                            <div class="uk-heading-divider"></div>
                            <div id="price-container"></div>
                            <div class="uk-heading-divider"></div>
                            <div class="uk-clearfix">
                                <div class="uk-float-right">
                                     <div id="total-price" class="uk-text-bold uk-text-large"></div>
                                     <div class="uk-text-small">inkl. 7.7% MwSt</div>
                                </div>
                                <div class="uk-float-left">
                                    <div class="uk-text-bold uk-text-large">Gesamttotal</div>
                                </div>
                            </div>
                            
                            <div class="uk-grid-small uk-margin-top" data-uk-grid>
                                <div class="uk-width-1-3@s">
                                    <p><strong>Rechnungsadresse</strong><br/>
                                        <span id="bill-address"></span>
                                    </p>
                                </div>
                                <div class="uk-width-2-3@s">
                                    <p>
                                        <strong>Lieferung</strong><br/>
                                        <span id="same-address"><span class="uk-margin-small-right" data-uk-icon="icon: check;"></span> identisch mit Rechnungsadresse</span>
                                        <span id="delivery-address"></span>
                                        <br/>
                                        Lieferungsperiode: von <span id="delivery-period"></span><br/>
                                        Telefonnummer: <span id="phone-number"></span> (<span id="phone-name"></span>)<br/>
                                    </p>
                                </div>
                                <div id="comments-container" class="uk-width-1-1">
                                    <strong>Bemerkungen</strong>
                                    <p id="comments"></p>
                                </div>
                            </div>
                        </div>
                        <div id="captcha-{$ID}" class="g-recaptcha" data-sitekey="6LeIrVYUAAAAANe_YUvsaHmkQktGaKvWnzLNAfP2" data-size="invisible"></div>
                        <div class="dk-text-content uk-width-1-1 uk-margin-small"><label class="acceptance"><input type="checkbox" name="acceptance" required /> Sie erklären sich damit einverstanden, dass ihre Daten zur Bearbeitung Ihres Anliegens verwendet werden. Weitere Informationen und Widerrufshinweise finden Sie in der <a href="/unternehmen/datenschutzerklaerung" title="Datenschutzerklärung Seite" target="_blank">Datenschutzerklärung</a>. Eine Kopie Ihrer Nachricht wird an Ihre E-Mail-Adresse geschickt. </label>
                        </div>
                        <div class="dk-text-content uk-width-1-1 uk-margin-small">
                            <label class="uk-form-label"><input type="checkbox" class=" uk-margin-small-right" name="AGB" required />$AGBHTML</label>
                        </div>
                        <div id="agb-error" class="uk-width-1-1" hidden><p class="uk-padding-small uk-background-muted">Bitte akzeptieren Sie die AGB um zu bestellen</p></div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="bill-address">Zurück</a>
            	           	<input id="submit-order" type="submit" class="uk-button uk-button-primary" value="$SubmitText">
            	        </div>
                    </div>
                </li>
            </ul>
        </form>
    
    </div>

