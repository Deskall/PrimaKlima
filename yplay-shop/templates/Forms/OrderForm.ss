<div class="dk-text-content">
    $HTML
</div>

<ul class="uk-subnav " data-uk-switcher>
    <li><a href="#">Item</a></li>
    <li><a href="#">Item</a></li>
    <li><a href="#">Item</a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
    <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sed do eiusmod.</li>
</ul>

    <%-- <div id="loading-block" class="uk-flex-middle"><p><span data-uk-spinner class="uk-margin-right"></span>Bitte warten Sie einen Moment, das Formular wird geladen.</p></div> --%>
   <div data-uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: true">
	   <nav class="uk-navbar-container uk-navbar-transparent" data-uk-navbar>
	       <div class="uk-navbar-center">
	       		<ul id="order-nav" class="uk-navbar-nav" data-uk-switcher>
	   	            <li class="uk-active" data-nav="1"><a >1. Kundendaten</a></li>
	   	            <li  data-nav="2">
	   	                <a>2. Bestellungsdaten</a>
	   	            </li>
	   	            <li data-nav="3"><a>3. Überprüfung</a></li>
	   	        </ul>
	       </div>
	   </nav>
	</div>
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
                <li class="uk-active uk-margin-top" data-step="customer">
                        <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                        	<div class="uk-margin">
                        		<h3><%t Order.ExitingCustomerTitle 'Sind Sie bereits YplaY-Kunde?' %></h3>
                        	</div>
                        	<div>
	                        	<div class="uk-flex uk-flex-around">
	                        		<button class="uk-button step" data-target="1" data-nav="1">Ja</button>
	                        		<button class="uk-button step" data-target="1" data-nav="1">Nein</button>
	                             </div>
	                         </div>
	                       <%--   <div id="email-container" hidden>
	                         	<p><%t ShopOrderPage.EmailInput 'Geben Sie Ihre E-Mail-Adresse ein.' %></p>
	                         	<input type="email" class="uk-input" >
	                         	<button class="uk-button"><%t ShopOrderPage.ButtonEmaillabel 'Konto Prüfen' %></button>
	                         </div> --%>
                        </div>
                        
                </li>
                <li class="uk-margin" data-step="address">
                  
                    
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	<% with Fields.FieldByName('AddressFields') %>
                        		$FieldHolder 
                        	<% end_with %>
                        </div>
                        <div>
	                        <div class="uk-margin-top uk-flex uk-flex-around">
	                        	<a class="step backwards uk-button uk-button-muted"  data-target="0" data-nav="1">Zurück</a>
	            	            <a class="step forward uk-button uk-button-primary"  data-target="3" data-nav="2">Weiter</a>
	            	        </div>
            	        </div>
                   
                </li>
                    <li class="uk-margin" data-step="bill-address">
                     
                        
                            
                            <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                            	<% with Fields.FieldByName('BillFields') %>
                            		$FieldHolder 
                            	<% end_with %>
                            </div>
                            <div class="uk-margin-small uk-flex uk-flex-around">
                            	<a class="step backwards uk-button uk-button-muted"  data-target="1" data-nav="1">Zurück</a>
                	            <a class="step forward uk-button uk-button-primary"  data-target="3" data-nav="2">Weiter</a>
                	        </div>
                       
                    </li>
                <% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-talk') %>
                <li class="uk-margin" data-step="phone">
                
                    
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	<% with Fields.FieldByName('PhoneTitle') %>
                        		$FieldHolder 
                        	<% end_with %>
                        	<div>
                        	<% with Fields.FieldByName('PhoneOption') %>
                        		$Field
                        	<% end_with %>
                        	</div>
                        </div>
                        <div class="uk-margin-small uk-align-center">
                        	<a class="step backwards uk-button uk-button-muted"  data-target="1" data-nav="1">Zurück</a>
            	            <a class="step forward uk-button uk-button-primary"  data-target="4" data-nav="2">Weiter</a>
            	        </div>
                    
                </li>
                <% end_if %>
       <%--          <% if Controller.activeCart && Controller.activeCart.hasCategory('yplay-mobile') %>
                <li class="uk-margin" data-step="mobile">
                        
                            
                            <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                            	
                            		
                            </div>
                            <div class="uk-margin-small uk-align-center">
                            	<a class="step backwards uk-button uk-button-muted"  data-target="2" data-nav="2">Zurück</a>
                	            <a class="step forward uk-button uk-button-primary"  data-target="4" data-nav="2">Weiter</a>
                	        </div>
                        </div>
                </li>
                <% end_if %> --%>
                <li class="uk-margin" data-step="options">
                    
                        
                            
                            <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                            	<% loop Controller.filteredOptions %>
                            	$Title
                            	<% end_loop %>
                            </div>
                            <div class="uk-margin-small uk-align-center">
                            	<a class="step backwards uk-button uk-button-muted"  data-target="3" data-nav="2">Zurück</a>
                	            <a class="step forward uk-button uk-button-primary"  data-target="5" data-nav="3">Weiter</a>
                	        </div>
                       
                </li>
                <li class="uk-margin" data-step="summary">
                   
                        
                        <div class="uk-grid-small uk-flex uk-flex-top" data-uk-grid>
                        	
                        		
                        </div>
                        <div class="uk-margin-small uk-align-right">
                        	<a class="step backwards uk-button uk-button-muted" href="#" data-target="4" data-nav="2">Zurück</a>
            	            <% if $Actions %>
	            	            <% loop $Actions %>
				        			$Field
				        		<% end_loop %>
				        	<% end_if %>
            	        </div>
                    
                </li>
            </ul>
        <% if $IncludeFormTag %>
        </form>
        <% end_if %>
    </div>

