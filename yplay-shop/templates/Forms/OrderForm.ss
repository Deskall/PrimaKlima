<div class="dk-text-content">
    $HTML
</div>


    <%-- <div id="loading-block" class="uk-flex-middle"><p><span data-uk-spinner class="uk-margin-right"></span>Bitte warten Sie einen Moment, das Formular wird geladen.</p></div> --%>
   <div data-uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: true">
	   <nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
	       <div class="uk-navbar-center">
	       		<ul class="uk-navbar-nav">
	   	            <li class="uk-active"><a >1. Kundendaten</a></li>
	   	            <li class="uk-disabled">
	   	                <a  disabled="disabled">2. Bestellungsdaten</a>
	   	            </li>
	   	            <li class="uk-disabled"><a  disabled="disabled">3. Überprüfung</a></li>
	   	        </ul>
	       </div>
	   </nav>
	</div>
    <div>
        
            <ul id="order-form-steps" data-uk-accordion>
                <li class="uk-open uk-margin" data-step="customer">
                   <%--  <div class="uk-accordion-title">1. Kundendaten</div> --%>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                        	<div>
                        		<p><%t Order.ExitingCustomerTitle 'Sind Sie bereits YplaY-Kunde?' %></p>
                        	</div>
                        	<div>
	                        	<div class="uk-flex uk-flex-around">
	                        		<button class="uk-button step" data-target="1">Ja</button>
	                        		<button class="uk-button step" data-target="1">Nein</button>
	                             </div>
	                         </div>
	                       <%--   <div id="email-container" hidden>
	                         	<p><%t ShopOrderPage.EmailInput 'Geben Sie Ihre E-Mail-Adresse ein.' %></p>
	                         	<input type="email" class="uk-input" >
	                         	<button class="uk-button"><%t ShopOrderPage.ButtonEmaillabel 'Konto Prüfen' %></button>
	                         </div> --%>
                        </div>
                    </div>       
                </li>
                <li data-step="address">
                   <%--  <div class="uk-accordion-title">2. Adresse</div> --%>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	<% with Fields.FieldByName('AddressFields') %>
                        		$FieldHolder 
                        	<% end_with %>
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="need">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="delivery">Weiter</a>
            	        </div>
                    </div>
                </li>
                <li class="uk-margin" data-step="address">
                   <%--  <div class="uk-accordion-title">2. Bestellungsdaten</div> --%>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="0">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="2">Weiter</a>
            	        </div>
                    </div>
                </li>
                <li class="uk-margin" data-step="summary">
                    <%-- <div class="uk-accordion-title">3. Überprüfen Sie Ihre Bestellung</div> --%>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="1">Zurück</a>
            	            <button class="uk-button" type="submit">Jetzt bestellen</a>
            	        </div>
                    </div>
                </li>
            </ul>
    </div>

