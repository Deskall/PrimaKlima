	<div id="mobile-cart-container" class="uk-hidden@m" <% if not $activeCart %>hidden="hidden"<% end_if %> data-uk-sticky>
		<div class="cart-container">
			<div class="uk-card uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header toggle-cart uk-padding-remove-horizontal" data-target="#mobile-order-preview">
					<div class="uk-position-relative">
						<strong class="uk-card-title uk-padding-small"><%t Configurator.CartLabel 'Warenkorb' %> - <span class="total-monthly-price">$activeCart.PrintMonthlyPrice</span></strong>
						<div class="uk-position-absolute uk-position-center-right">
							<button type="button" class="cart-button show"><span data-uk-icon="icon:chevron-down;ratio:1.5"></span></button>
							<button type="button" class="cart-button uk-hidden hide"><span data-uk-icon="icon:chevron-up;ratio:1.5"></span></button>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	<div id="mobile-order-preview" hidden>
		<div class="uk-card-body WhiteBackground order-preview">
		</div>
		<div class="uk-card-footer BlackBackground">
			<a href="$ShopPage.Link" class="uk-button uk-button-primary uk-display-block"><%t Configurator.Order 'Bestellen' %></a>
		</div>
	</div>
	<section class="uk-section uk-section-medium" style="background-color:#eee;">
		<div class="uk-container uk-container-medium">
			<h1>$Title</h1>
			<%-- <h2>$SiteConfig.ConfiguratorTitle</h2> --%>
			<% if not activePLZ %>

			<% if $chosenItem %>
			<strong>Ihre Auswahl: $chosenItem.Title</strong>
			<% end_if %>

			$SiteConfig.PLZModalBody
			<form method="POST" action="{$Link}plz-speichern" class="form-std plz-form">
				<div class="uk-flex uk-flex-left uk-flex-top">
				   <div>
				        <input class="uk-input uk-text-center" type="text" name="plz-choice" required="required" placeholder="Ihrer PLZ">
				   </div>
				   <button class="uk-button uk-button-primary" type="submit">Region prüfen</button>
				</div>
			</form>
			<% else %>
				<% if activePLZ.AlternateOffer %>
				<div>
		          <h3><%t Order.ExistingTVConnection 'Ihre Anschluss-Art' %></h3>
		          <div class="uk-child-width-1-3" data-uk-grid>
		          	<div><a><img src="$ThemeDir/img/bestellung-glasfaserdose.svg" data-value="GlasfaserDose" data-type="FTTH" alt="<%t Order.FiberTV 'Glasfaser-Dose' %>" title="<%t Order.FiberTV 'Glasfaser-Dose' %>"/><span class="uk-display-block uk-margin-top uk-text-center"><%t Order.FiberTV 'Glasfaser-Dose' %><a data-uk-toggle="target: #Glasfaser-Dose-modal" class="uk-margin-small-left"><span data-uk-icon="info" class="uk-margin-small-right"></span></a></span></a></div>
		            <div><a><img src="$ThemeDir/img/bestellung-dose-f75.svg" data-value="Kabelnetz" data-type="Coax" alt="<%t Order.CableTV 'Kabel-TV-Dose' %>" title="<%t Order.CableTV 'Kabel-TV-Dose' %>"/><span class="uk-display-block uk-margin-top uk-text-center"><%t Order.CableTV 'Kabel-TV-Dose' %><a data-uk-toggle="target: #Kabel-TV-Dose-modal" class="uk-margin-small-left"><span data-uk-icon="info" class="uk-margin-small-right"></span></a> </span></a></div>
		            <div><a><img src="$ThemeDir/img/bestellung-dose-unknown.svg" data-value="Dose noch nicht bekannt" data-type="unknown" alt="<%t Order.UnknownTV 'Dose noch nicht bekannt' %>" title="<%t Order.UnknownTV 'Dose noch nicht bekannt' %>"/><span class="uk-display-block uk-margin-top uk-text-center"><%t Order.UnknownTV 'Dose noch nicht bekannt' %></span></a></div>
		          </div>
		        </div>
				        
		        <% with OrderConfig %>
		        <div id="Kabel-TV-Dose-modal" data-uk-modal>
		            <div class="uk-modal-dialog uk-modal-body">
		                    <h2 class="uk-modal-title">$KabelTVDoseModalTitle</h2>
		                    <div class="dk-text-content">$KabelTVDoseModalContent</div>
		                    <p class="uk-text-right">
		                        <button class="uk-button uk-button-primary uk-modal-close" type="button"><%t General.Close 'Schliessen' %></button>
		                    </p>
		                </div>
		        </div>
		        <div id="Glasfaser-Dose-modal" data-uk-modal>
		            <div class="uk-modal-dialog uk-modal-body">
		                    <h2 class="uk-modal-title">$GlasfaserDoseModalTitle</h2>
		                    <div class="dk-text-content">$GlasfaserDoseModalContent</div>
		                    <p class="uk-text-right">
		                        <button class="uk-button uk-button-primary uk-modal-close" type="button"><%t General.Close 'Schliessen' %></button>
		                    </p>
		                </div>
		        </div>
		        <% end_with %>
				<% end_if %>
				<div <% if activePLZ.AlternateOffer %>hidden<% end_if %>>
					<div id="loading-block" class="uk-text-left">
						<p><span data-uk-spinner="ratio: 2" class="uk-margin-right"></span>Produkte werden geladen. Einen Moment bitte.</p>
					</div>
					<div id="products-hidden-container">
						<div class="uk-grid-small uk-grid-match" data-uk-grid>
							<div class="uk-width-2-3@m">
								<% loop activeCategories %>
								<div class="category uk-text-center $Code uk-margin-large" <% if not Mandatory %>data-disabled="$isDisabled"<% end_if %> data-mandatory="$Mandatory">
									<div class="uk-flex uk-flex-middle uk-flex-center uk-margin-small-bottom"><img src="$Icon.URL" width="50" class="uk-margin-small-right" alt="$Icon.Alt"><h3 class="uk-margin-remove uk-flex uk-flex-middle">$Title <% if not Mandatory %><label class="switch uk-margin-small-left"><span class="slider round"></span></label><% end_if %></h3></div>

									$Description
									
									
										<div id="category-{$ID}" class="uk-padding-small <% if Code != "yplay-mobile" %>slider-packages<% end_if %> slider-products uk-padding-remove-bottom" data-id="$activeIndex" data-code="$Code">

										    
										    	<div class="uk-slider-container">
											        <ul class="uk-slider-items uk-child-width-2-3 uk-child-width-1-2@s uk-grid-match">
											            <% loop filteredProducts %>
											            <li data-product-id="$ID" data-index="$Pos" data-title="$Title" data-value="$ProductCode">
											                <div class="uk-card uk-card-default uk-border-rounded uk-card-hover uk-box-shadow-medium uk-card-small">
											                    <div class="uk-card-body">
											                        <h3 class="uk-card-title">$Title</h3>
											                        <%-- <div class="price">$PrintPriceString</div> --%>
											                        $Subtitle
											                    </div>
											                </div>
											            </li>
											            <% end_loop %>
											        </ul>
											    </div>
											<div class="uk-flex uk-flex-between uk-flex-middle">
												<a  data-uk-slider-item="previous"><i class="icon icon-chevron-left"></i></a>
											    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
											    <a  data-uk-slider-item="next"><i class="icon icon-chevron-right"></i></a>
											</div>
										</div>
									<div class="uk-margin-small">
										<a data-uk-toggle="#modal-category-{$Code}">Mehr erfahren</a>
									</div>
									<% if not Mandatory %>
									<div class="not-included-input">
										<input id="no-{$ID}" name="no-{$ID}" type="checkbox" class="uk-checkbox no-category" <% if not Preselected %>checked="checked"<% end_if %>>
										<label for="no-{$ID}"><%t Category.NotIncluded 'Keine {title} Angebot' title=$Title %></label>
									</div>
									<% end_if %>
									<input type="hidden" name="$Code" data-product-choice>
								</div>
								<div id="modal-category-{$Code}" class="uk-modal-full category-modal $Code" data-uk-modal>
								    <div class="uk-modal-dialog">
								        <button class="uk-modal-close-full uk-close-large" type="button" data-uk-close></button>
								        <div data-uk-slider="finite:true;draggable:false;">
									        <div class="uk-modal-header">
									        	<div class="uk-flex uk-flex-middle uk-margin-small-bottom"><img src="$Icon.URL" width="50" class="uk-margin-small-right" alt="$Icon.Description"><h2 class="uk-modal-title uk-margin-remove">$Title</h2></div>
									        </div>
									        <div class="uk-modal-body uk-padding-remove-vertical"  data-uk-height-viewport="offset-bottom:162px;">
								        	    <div class="uk-slider-container uk-height-1-1">
								        		   <ul class="uk-slider-items uk-child-width-1-1 uk-grid-match  uk-height-1-1" >
												        <li>
												        	<div class="uk-child-width-1-2@s uk-grid-match" data-uk-grid>
											        		<div class="uk-hidden@m">
											        			<div class="uk-background-cover uk-height-small" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
											        		</div>
												            <div class="uk-visible@m">
												            	<div class="uk-background-cover" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
												            </div>
												            <div data-uk-slider-parallax="x: 100,0,0; opacity: 1,1,0">
												                <h1>Info 1</h1>
												                <div>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													            </div>
												            </div>
												        	</div>
												        </li>
												        <li>
												        	<div class="uk-child-width-1-2@s uk-grid-match" data-uk-grid>
											        		<div class="uk-hidden@m">
											        			<div class="uk-background-cover uk-height-small" style="background-image: url('$ThemeDir/img/paul-green-mln2ExJIkfc-unsplash.jpg');"></div>
											        		</div>
												            <div class="uk-visible@m">
												            	<div class="uk-background-cover" style="background-image: url('$ThemeDir/img/paul-green-mln2ExJIkfc-unsplash.jpg');"></div>
												            </div>
												            <div>
												                <h1 data-uk-slider-parallax="x: 100,0,0; opacity: 1,1,0">Info 2</h1>
												                <div data-uk-overflow-auto data-uk-slider-parallax="x: 100,0,0; opacity: 1,1,0">
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
													            </div>
												            </div>
												        	</div>
												        </li>
												    </ul>
												</div>
											</div>
									        <div class="uk-modal-footer uk-box-shadow-small">
									        	<div class="uk-flex uk-flex-between uk-flex-middle">
									        		<a data-uk-slider-item="previous"><i class="icon icon-chevron-left"></i></a>
									        		<button class="uk-button uk-modal-close" type="button">Schliessen</button>
									        		<a data-uk-slider-item="next"><i class="icon icon-chevron-right"></i></a>
									        	</div>
									        </div>
									    </div>
								    </div>
								</div>
								<% end_loop %>
								<div class="uk-margin uk-hidden@m">
									<a href="$ShopPage.Link" class="uk-button BlackBackground uk-display-block"><%t Configurator.Order 'Bestellen' %></a>
								</div>
								<%-- Remove alternate Offer <div class="uk-margin">
									<ul data-uk-accordion>
									    <li class="WhiteBackground uk-padding-small uk-box-shadow-medium uk-margin">
									        <a class="uk-accordion-title">$OtherOffersTitle</a>
									        <div class="uk-accordion-content">
									           	$OtherOffersLabel
									           	<% if alternativePackages.exists %>
									            <div class="uk-grid-small uk-grid-match uk-child-width-1-3@m" data-uk-grid>
									            	<% loop alternativePackages %>
									            	<div>
									            		<div class="uk-card uk-card-default uk-card-hover uk-card-body">
									            		    <h3 class="uk-card-title">$Title</h3>
									            		    <strong>$PrintPriceString</strong>
									            		    <table class="uk-table uk-table-divider uk-table-justify uk-table-middle">
									            		    	<% if Items %>
										            		    	<% loop Items %>
										            		    	<tr>
										            		    		<td><strong>$Title</strong></td>
										            		    		<td>$Content</td>
										            		    	</tr>
										            		    	<% end_loop %>
										            		    <% else_if Products %>
										            		    	<% loop Products %>
										            		    	<tr>
										            		    		<td><strong>$Title</strong></td>
										            		    		<td>$SubTitle</td>
										            		    	</tr>
										            		    	<% end_loop %>
										            		    <% end_if %>
									            		    </table>
									            		    <div class="uk-margin">
									            		    	<a class="uk-button BlackBackground uk-display-block" href="{$Top.ShopPage.Link}paket/$ID"><%t ConfiguratorPage.Order 'Bestellen' %></a>
									            		    </div>
									            		</div>
									            	</div>
									            	<% end_loop %>
									            </div>
									            <% else_if alternativeProducts.exists %>
									            <div class="uk-grid-small uk-grid-match uk-child-1-3@m" data-uk-grid>
									            	<% loop alternativeProducts %>
									            	<div>
									            		<div class="uk-card uk-card-default uk-card-hover uk-card-body uk-transition-toggle">
									            		    <h3 class="uk-card-title">$Title</h3>
									            		    <strong>$PrintPriceString</strong>
									            		    <table class="uk-table uk-table-divider uk-table-justify uk-table-middle">
									            		    	<% if Subtitle %>
									            		    	<tr>
									            		    		<td colspan="2">$Subtitle</td>
									            		    	</tr>
									            		    	<% end_if %>
									            		    	<% if Items %>
										            		    	<% loop Items %>
										            		    	<tr>
										            		    		<td><strong>$Title</strong></td>
										            		    		<td>$Content</td>
										            		    	</tr>
										            		    	<% end_loop %>
										            		    <% end_if %>
									            		    </table>
									            		    <div class="uk-margin uk-transition-fade">
									            		    	<a class="uk-button BlackBackground" href="{$Top.ShopPage.Link}produkt/$ID"><%t ConfiguratorPage.Order 'Bestellen' %></a>
									            		    </div>
									            		</div>
									            	</div>
									            	<% end_loop %>
									            </div>
									            <% end_if %>
									        </div>
									    </li>
									</ul>
								</div> --%>
								<div class="uk-margin">
									<div class="conditions-container">$ConditionsText</div>
								</div>
							</div>
							<div class="uk-width-expand uk-visible@m">
								<div data-uk-sticky="media:@m;offset:150;bottom:true;">
									<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
										<div class="uk-card-header">
											<h3 class="uk-card-title"><%t Configurator.AboLabel 'Bestellübersicht' %></h3>
										</div>
										<div class="uk-card-body order-preview">
											
										</div>
										<div class="uk-card-footer">
											<a href="$ShopPage.Link" class="uk-button BlackBackground"><%t Configurator.Order 'Bestellen' %></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<% end_if %>
		</div>
	</section>

	<% include ModalConditions %>