<div class="dk-text-content">
    $HTML
</div>


    <%-- <div id="loading-block" class="uk-flex-middle"><p><span data-uk-spinner class="uk-margin-right"></span>Bitte warten Sie einen Moment, das Formular wird geladen.</p></div> --%>
   
	   <nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
	       		<ul id="order-nav" class="uk-navbar-nav uk-width-1-1 uk-flex uk-flex-around">
	   	            <li <% if Controller.activeCart && Controller.activeCart.CurrentStep == "1" || not Controller.activeCart.CurrentStep %>class="uk-active"<% end_if %> data-nav="1"><a>1. <span class="uk-visible@m">Kundendaten</span></a></li>
	   	            <li <% if Controller.activeCart && Controller.activeCart.CurrentStep == "2" %>class="uk-active"<% else_if Controller.activeCart.CurrentStep < 2 %>class="dk-inactive"<% end_if %> data-nav="2">
	   	                <a>2. <span class="uk-visible@m">Bestellungsdaten</span></a>
	   	            </li>
	   	            <li <% if Controller.activeCart && Controller.activeCart.CurrentStep == "3" %>class="uk-active"<% else_if Controller.activeCart.CurrentStep < 3 %>class="dk-inactive"<% end_if %> data-nav="3"><a>3. <span class="uk-visible@m">Überprüfung</span></a></li>
	   	        </ul>
	   	        <ul id="order-nav-switcher" data-uk-switcher="connect:#order-form-steps" hidden>
	   	            <li class="uk-active"><a>ist Kunde?</a></li>
                    <li><a>Kundendaten</a></li>
                    <li><a>Kundendaten 2</a></li>
	   	            <li><a>Adresse / Rechnung</a></li>
	   	            <% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-talk') %><li><a >Telefon</a></li><% end_if %>
	   	            <% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-mobile') %><li><a >Mobile</a></li><% end_if %>
	   	            <li><a >Optionen</a></li>
	   	            <li><a >Übersicht</a></li>
	   	        </ul>
	   </nav>
	
    <div>
    <% if $IncludeFormTag %>
    <form $AttributesHTML>
    <% end_if %>
    <% if $Message %>
    <p id="{$FormName}_error" class="message $MessageType">$Message</p>
    <% else %>
    <p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
    <% end_if %>
            <ul id="order-form-steps" class="uk-switcher">
                <li class="uk-active uk-margin-top" data-step="customer" data-index="0">
                        <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                        	<h3><%t Order.ExitingCustomerTitle 'Sind Sie bereits YplaY-Kunde?' %></h3>
                        	<div class="uk-margin-large-top">
	                        	<div class="uk-flex uk-flex-around">
	                        		<button class="uk-button step forward customer-button" data-nav="1" type="button" data-value="1">Ja</button>
	                        		<button class="uk-button step forward customer-button" data-nav="1" type="button" data-value="0">Nein</button>
	                             </div>
	                         </div>
	                         <% with Fields.FieldByName('ExistingCustomer') %>
	                         	$FieldHolder 
	                         <% end_with %>
	                       <%--   <div id="email-container" hidden>
	                         	<p><%t ShopOrderPage.EmailInput 'Geben Sie Ihre E-Mail-Adresse ein.' %></p>
	                         	<input type="email" class="uk-input" >
	                         	<button class="uk-button"><%t ShopOrderPage.ButtonEmaillabel 'Konto Prüfen' %></button>
	                         </div> --%>
                        </div>
                        
                </li>
                <li id="address" class="uk-margin" data-step="step-1">
                        <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid>
                           <h3>Ihre Angaben</h3>
                        	<% with Fields.FieldByName('Step1') %>
                        		$FieldHolder 
                        	<% end_with %>
                            <div><label>Ihre Geburstdatum *</label></div>
                            <div>
                                <div class="uk-display-inline-block">
                                        <% with Fields.FieldByName('Birthday') %>
                                            $FieldHolder 
                                        <% end_with %>
                                </div>
                                <div class="uk-display-inline-block">
                                        <% with Fields.FieldByName('BirthMonth') %>
                                            $FieldHolder 
                                        <% end_with %>
                                </div>
                                <div class="uk-display-inline-block">  
                                        <% with Fields.FieldByName('BirthYear') %>
                                            $FieldHolder 
                                        <% end_with %>
                                </div>
                            </div>
                            <div id="birthdate-error" hidden="hidden">
                                <p class="error">Sie müssen mindestens 18 Jahre alt sein, um auf unserer Website bestellen zu können</p>
                            </div>
                            <div id="birthdate-empty" hidden="hidden">
                                <p class="error">Dieses Feld ist ein Pflichtfeld.</p>
                            </div>
                            
                            <% with Fields.FieldByName('Birthdate') %>
                                $FieldHolder 
                            <% end_with %>
                            
                        </div>
	                   <div class="uk-margin-top uk-flex uk-flex-around">
	                        <a class="step backwards uk-button uk-button-muted" data-nav="1"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
	            	        <a class="step forward uk-button" data-nav="1">Weiter<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
	            	  </div>
                </li>
                <li class="uk-margin" data-step="step-2">
                        <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid>
                            <h3>Ihre Angaben</h3>
                            <% with Fields.FieldByName('Step2') %>
                                $FieldHolder 
                            <% end_with %>
                        </div>
                       <div class="uk-margin-top uk-flex uk-flex-around">
                            <a class="step backwards uk-button uk-button-muted" data-nav="1"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
                            <a class="step forward uk-button" data-nav="1">Weiter<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
                      </div>
                </li>
                <li class="uk-margin" data-step="step-3">
                        <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid>
                            <h3>Ihre Adresse</h3>
                            <div class="uk-width-3-4 uk-width-4-5@l">
                                <% with Fields.dataFieldByName('Address') %>
                                    $FieldHolder 
                                <% end_with %>
                            </div>
                            <div class="uk-width-1-4 uk-width-1-5@l">
                                <% with Fields.dataFieldByName('HouseNumber') %>
                                    $FieldHolder 
                                <% end_with %>
                            </div>
                            <div class="uk-width-1-2@s uk-width-1-3@m uk-width-1-5@l">
                                <% with Fields.dataFieldByName('PostalCode') %>
                                    $FieldHolder 
                                <% end_with %>
                            </div>
                            <div class="uk-width-1-2@s  uk-width-2-3@m uk-width-4-5@l">
                                <% with Fields.dataFieldByName('City') %>
                                    $FieldHolder 
                                <% end_with %>
                            </div>
                            <% with Fields.dataFieldByName('BillSameAddress') %>
                                $FieldHolder 
                            <% end_with %>
                        </div>
                        <div id="bill-fields" class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid hidden>
                            <% with Fields.FieldByName('BillFields') %>
                                $FieldHolder 
                            <% end_with %>
                        </div>
                       <div class="uk-margin-top uk-flex uk-flex-around">
                            <a class="step backwards uk-button uk-button-muted" data-nav="1"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
                            <a class="step forward uk-button" data-nav="2">Weiter<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
                      </div>
                </li>
                <% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-talk') %>
                <li class="uk-margin" data-step="phone">
                        <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid>
                            <h3>Ihre Telefonnummer</h3>
                        	<% with Fields.FieldByName('PhoneTitle') %>
                        		$FieldHolder 
                        	<% end_with %>
                        	<div>
                        	<% with Fields.FieldByName('PhoneOption') %>
                        		$Field
                        	<% end_with %>
                        	</div>
                            <% with Fields.FieldByName('ExistingPhone') %>
                            <div id="existing-phone" class="uk-margin" hidden>
                                <div>
                                    $Field
                                </div>
                                <div>
                                    $SiteConfig.ExistingNumberLabel
                                </div>
                            </div>
                            <% end_with %>
                            <% with Fields.FieldByName('WishPhone') %>
                            <div id="wish-phone" class="uk-margin" hidden>
                                <div >
                                    $Field
                                </div>
                                <div>
                                    <a data-uk-toggle="#modal-wish-number"><i><i class="icon icon-information-circled uk-margin-small-right"></i>$SiteConfig.WishNumberTitle</i></a>
                                </div>
                            </div>
                            <% end_with %>
                        </div>
                        <div class="uk-margin-large-top uk-flex uk-flex-around">
                        	<a class="step backwards uk-button uk-button-muted" data-nav="1"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
            	            <a class="step forward uk-button" data-nav="2">Weiter<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
            	        </div>
                        <% include Includes/ModalWishNumber %>
                </li>
                <% end_if %>
                <% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-mobile') %>
                <li class="uk-margin" data-step="mobile">
                            <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid>
                                <h3>$SiteConfig.MobileStepTitle</h3>
                            	<div>
                                    $SiteConfig.MobileStepBody
                                </div>
                            </div>
                            <div class="uk-margin-large-top uk-flex uk-flex-around">
                                <a class="step backwards uk-button uk-button-muted" data-nav="<% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-talk') %>2<% else %>1<% end_if %>"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
                                <a class="step forward uk-button" data-nav="2">Weiter<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
                            </div>
                </li>
                <% end_if %>
                <% if Controller.filteredOptions.exists %>
                <li class="uk-margin" data-step="options">
                    
                        <h3>Optionen</h3>
                            
                            <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top uk-child-width-1-1 options" data-uk-grid>
                            	<% loop Controller.filteredOptions.groupedBy(CategoryTitle) %>
                            	 <div class="uk-card uk-card-hover uk-box-shadow-medium uk-card-body uk-transition-toggle">
						           	<h4 class="uk-card-title">$CategoryTitle</h4>
						           	<table class="uk-table uk-table-small uk-table-hover">
						           		<% loop Children %>
							           		<% if hasOptions %>
                                                <tr><td colspan="3"><strong>$Title</strong></td></tr>
								           		<% loop Options %>
								           		<%-- <tr><td class="uk-table-shrink"><input type="checkbox" class="uk-checkbox <% if Single %>pseudo-radio<% end_if %>" name="$Group.ProductCode" data-value="$ProductCode" <% if Multiple %>data-is-multiple="true"<% end_if %><% if $inCart %>checked="checked"<% end_if %> ></td><td>$Title</td><% if Multiple %><td><input type="number" name="quantity-{$ProductCode}" class="uk-input quantity" <% if not $inCart %>hidden<% end_if %>" /></td><% end_if %><td class="uk-text-right">$PrintPriceString</td></tr> --%>
                                                <tr><td class="uk-table-shrink"><input type="checkbox" class="uk-checkbox <% if Single %>pseudo-radio<% end_if %>" name="$Group.ProductCode" data-value="$ProductCode" <% if $inCart %>checked="checked"<% end_if %> ></td><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
								           		<% end_loop %>
								           	<% else %>
								           	<tr><td class="uk-table-shrink"><input type="checkbox" class="uk-checkbox" name="$ProductCode" data-value="$ProductCode" <% if $inCart %>checked="checked"<% end_if %> ></td><td>$Title</td><td class="uk-text-right">$PrintPriceString</td></tr>
								           	<% end_if %>
							           	<% end_loop %>
						           	</table>
						         </div>
                            	<% end_loop %>
                            </div>
                            <div class="uk-margin-top uk-flex uk-flex-around">
                            	<a class="step backwards uk-button uk-button-muted" data-nav="<% if Controller.activeCart.hasCategory('yplay-talk') || Controller.activeCart.hasCategory('yplay-mobile') %>2<% else %>1<% end_if %>"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
                	            <a class="step forward uk-button" data-nav="3">Weiter<i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
                	        </div>
                       
                </li>
                <% end_if %>
                <li class="uk-margin" data-step="summary">
                   
                        
                        <div class="uk-grid-small uk-child-width-1-1 uk-flex uk-flex-top" data-uk-grid>
                        	<% with Fields.FieldByName('OtherFields') %>
                        		$FieldHolder 
                        	<% end_with %>
                        </div>
                        <div class="uk-margin-top uk-flex uk-flex-around uk-flex-wrap-reverse uk-flex-wrap-between">
                        	<a class="step backwards uk-button uk-button-muted uk-margin-top" href="#" data-nav="2"><i class="uk-margin-small-right" data-uk-icon="chevron-left"></i>Zurück</a>
            	            <% if $Actions %>
	            	            <% loop $Actions %>
				        			$Field
				        		<% end_loop %>
				        	<% end_if %>
            	        </div>
                    
                </li>
            </ul>
            <% with Fields.FieldByName('SecurityID') %>
            	$FieldHolder 
            <% end_with %>
        <% if $IncludeFormTag %>
        </form>
        <% end_if %>
    </div>


