<div class="dk-text-content">
    $HTML
</div>


    <%-- <div id="loading-block" class="uk-flex-middle"><p><span data-uk-spinner class="uk-margin-right"></span>Bitte warten Sie einen Moment, das Formular wird geladen.</p></div> --%>
    <div id="order-form-content">
        <form id="order-form" method="post" action="{$Link}SendOrderForm">
            <ul id="pellets-order-container" class="bestellung-container" data-uk-accordion>
                <li class="uk-open" data-step="customer">
                    <div class="uk-accordion-title">1. Kundendaten</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                        	<p><%t Order.ExitingCustomerTitle 'Sind Sie bereits YplaY-Kunde?' %></p>
                        	<div class="uk-flex uk-flex-around">
                        		<button class="uk-button">Ja</button>
                        		<button class="uk-button">Nein</button>
                             </div>
                        </div>
                    </div>       
                </li>
               <%--  <li data-step="address">
                    <div class="uk-accordion-title">2. Adresse</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="need">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="delivery">Weiter</a>
            	        </div>
                    </div>
                </li> --%>
                <li data-step="address">
                    <div class="uk-accordion-title">2. Bestellungsdaten</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="need">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="delivery">Weiter</a>
            	        </div>
                    </div>
                </li>
                <li data-step="address">
                    <div class="uk-accordion-title">3. Überprüfen Sie Ihre Bestellung </div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="need">Zurück</a>
            	            <a class="step uk-button uk-button-primary" href="#" data-target="delivery">Weiter</a>
            	        </div>
                    </div>
                </li>
            </ul>
        </form>
    
    </div>

