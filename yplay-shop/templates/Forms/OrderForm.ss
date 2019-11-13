<div class="dk-text-content">
    $HTML
</div>


    <%-- <div id="loading-block" class="uk-flex-middle"><p><span data-uk-spinner class="uk-margin-right"></span>Bitte warten Sie einen Moment, das Formular wird geladen.</p></div> --%>
    <div id="order-form-content">
        <form id="order-form" method="post" action="{$Link}SendOrderForm">
            <ul id="pellets-order-container" class="bestellung-container" data-uk-accordion>
                <li class="uk-open" data-step="need">
                    <div class="uk-accordion-title">Bedarf</div>
                    <div class="uk-accordion-content uk-padding-small uk-padding-remove-horizontal uk-padding-remove-top">
                        
                        <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                        	
                                
                        </div>
                    </div>       
                </li>
                <li data-step="products">
                    <div class="uk-accordion-title">Preise</div>
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

