

	
	<section class="uk-section uk-section-medium">
		<div class="uk-container uk-container-medium">
			<h1>$Title</h1>
			<h2><%t Configurator.Title 'Wählen Sie Ihr Paket' %></h2>
			<div class="uk-grid-small" data-uk-grid>
				<div class="uk-width-2-3@m">
					<% loop activeCategories %>
					<div class="category uk-text-center $Code uk-margin-large">
						<div class="uk-flex uk-flex-middle uk-flex-center uk-margin-small-bottom"><img src="$Icon.URL" width="50" alt="$Icon.Alt"><h3 class="uk-margin-remove">$Title</h3></div>
						
						$Description
						
						
							<div class="uk-padding-small" data-uk-slider="center:true;index:1;">

							    
							    	<div class="uk-slider-container">
								        <ul class="uk-slider-items uk-child-width-1-2 uk-grid-match">
								            <% loop Products %>
								            <li>
								                <div class="uk-card uk-card-default uk-border-rounded uk-card-hover uk-box-shadow-medium uk-card-small">
								                    <div class="uk-card-body">
								                        <h3 class="uk-card-title">$Title</h3>
								                        <div class="price">$PrintPriceString</div>
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
							<a data-uk-toggle="#modal-category-{$Code}">Mehr Erfahren</a>
						</div>
						<div class="not-included-input">
							<input id="no-{$ID}" name="no-{$ID}" type="checkbox" class="uk-checkbox">
							<label for="no-{$ID}"><%t Category.NotIncluded 'Keine {title} Angebot' title=$Title %></label>
						</div>
					</div>
					<div id="modal-category-{$Code}" class="uk-modal-full category-modal $Code" data-uk-modal>
					    <div class="uk-modal-dialog">
					        <button class="uk-modal-close-full uk-close-large" type="button" data-uk-close></button>
					        <div data-uk-slider="finite:true;draggable:false;">
						        <div class="uk-modal-header">
						        	<div class="uk-flex uk-flex-middle uk-margin-small-bottom"><img src="$Icon.URL" width="50" class="uk-margin-small-right" alt="$Icon.Description"><h2 class="uk-modal-title uk-margin-remove">$Title</h2></div>
						        </div>
						        <div class="uk-modal-body uk-padding-remove-vertical">
					        	    <div class="uk-slider-container">
					        		   <ul class="uk-slider-items uk-child-width-1-1 uk-grid-match">
									        <li>
									        	<div class="uk-child-width-1-2@s uk-grid-match" data-uk-grid>
								        		<div class="uk-hidden@m">
								        			<div class="uk-background-cover uk-height-small" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
								        		</div>
									            <div class="uk-visible@m">
									            	<div class="uk-background-cover" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
									            </div>
									            <div>
									                <h1>Info 1</h1>
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
				</div>
				<div class="uk-width-expand uk-visible@m">
					<div data-uk-sticky="media:@m">
						<div class="uk-card uk-card-hover uk-box-shadow-medium uk-card-small">
							<div class="uk-card-header">
								<h3 class="uk-card-title"><%t Configurator.AboLabel 'Ihr Abo' %></h3>
							</div>
							<div class="uk-card-body">
								<p>Aenean vel tempor sapien, sit amet interdum erat. Pellentesque congue at ipsum ut condimentum.</p>
							</div>
							<div class="uk-card-footer">
								<a href="/bestellen" class="uk-button uk-button-primary"><%t Configurator.Order 'Bestellen' %></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="uk-hidden@m">
				<div class="uk-position-fixed uk-position-bottom uk-position-z-index">
					<div class="uk-card BlackBackground uk-box-shadow-medium uk-card-small" data-uk-accordion="targets:.uk-card-body;toggle:button">
						<div class="uk-card-header">
							<div class="uk-position-relative">
								<strong class="uk-card-title"><%t Configurator.AboLabel 'Ihr Abo' %> - CHF 45.- / Mt.</strong>
								<div class="uk-position-absolute uk-position-right">
									<%-- <button type="button" data-uk-toggle="target: #my-id; animation: uk-animation-slide-up" data-uk-icon="chevron-up"></button> --%>
									<button type="button"  data-uk-icon="chevron-up"></button>
								</div>
							</div>
						<div id="my-id" class="uk-card-body" hidden>
							<div class="uk-flex uk-flex-middle uk-flex-around">
								<span class="chosen-product yplay-tv">
									Watch M
								</span>
								<span class="chosen-product yplay-internet">
									Surf M
								</span>
								<span class="chosen-product yplay-telefonie">
									Talk S
								</span>
								<span class="chosen-product yplay-mobile">
									Talk S
								</span>
							</div>
						</div>
						<div class="uk-card-footer">
							<a href="/bestellen" class="uk-button uk-button-primary"><%t Configurator.Order 'Bestellen' %></a>
						</div>
					</div>
				</div>
			</div>
			<%-- <% loop activeCategories %>
				<div class="category uk-text-center $Code uk-margin-large">
					<div class="uk-grid-small uk-flex uk-flex-middle" data-uk-grid>
						<div class="uk-width-1-1 uk-width-1-3@m uk-width-1-5@l">
							<img src="$Icon.URL" width="50" alt="$Icon.Alt">
							<h3 class="uk-margin-remove">$Title</h3>
						</div>
						<div  class="uk-width-1-1 uk-width-1-3@m uk-width-3-5@l">
								<div class="uk-padding-small" data-uk-slider="center:true;index:1;">
								    	<div class="uk-slider-container">
									        <ul class="uk-slider-items uk-child-width-1-2 uk-grid-match">
									            <% loop Products %>
									            <li>
									                <div class="uk-card uk-card-default uk-border-rounded uk-card-hover uk-box-shadow-medium uk-card-small">
									                    <div class="uk-card-body">
									                        <h3 class="uk-card-title">$Title</h3>
									                        <div class="price">$PrintPriceString</div>
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
								<a data-uk-toggle="#modal-category-{$Code}">Mehr Erfahren</a>
							</div>
							<div class="not-included-input">
								<input id="no-{$ID}" name="no-{$ID}" type="checkbox" class="uk-checkbox">
								<label for="no-{$ID}"><%t Category.NotIncluded 'Keine {title} Angebot' title=$Title %></label>
							</div>
						</div>
						<div  class="uk-width-1-1 uk-width-1-3@m uk-width-1-5@l">
							<div class="price">CHF 25.- / Mt</div>
						</div>
						
					
					
						
					</div>
					<div id="modal-category-{$Code}" class="uk-modal-full category-modal $Code" data-uk-modal>
					    <div class="uk-modal-dialog">
					        <button class="uk-modal-close-full uk-close-large" type="button" data-uk-close></button>
					        <div data-uk-slider="finite:true;draggable:false;">
						        <div class="uk-modal-header">
						        	<div class="uk-flex uk-flex-middle uk-margin-small-bottom"><img src="$Icon.URL" width="50" class="uk-margin-small-right" alt="$Icon.Description"><h2 class="uk-modal-title uk-margin-remove">$Title</h2></div>
						        </div>
						        <div class="uk-modal-body uk-padding-remove-vertical">
					        	    <div class="uk-slider-container">
					        		   <ul class="uk-slider-items uk-child-width-1-1 uk-grid-match">
									        <li>
									        	<div class="uk-child-width-1-2@s uk-grid-match" data-uk-grid>
								        		<div class="uk-hidden@m">
								        			<div class="uk-background-cover uk-height-small" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
								        		</div>
									            <div class="uk-visible@m">
									            	<div class="uk-background-cover" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
									            </div>
									            <div>
									                <h1>Info 1</h1>
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
				</div>
			<% end_loop %>
			<div  data-uk-scrollspy="target: > div;cls: uk-position-fixed uk-position-bottom uk-position-z-index;">
				<div class="uk-position-fixed uk-position-bottom uk-position-z-index" >
					<div class="uk-card uk-card-primary uk-box-shadow-medium uk-card-small">
						<div class="uk-card-header">
							<h3 class="uk-card-title"><%t Configurator.AboLabel 'Ihr Abo' %></h3>
						</div>
						<div class="uk-card-body">
							<p>Aenean vel tempor sapien, sit amet interdum erat. Pellentesque congue at ipsum ut condimentum.</p>
						</div>
						<div class="uk-card-footer">
							<a href="/bestellen" class="uk-button uk-button-primary"><%t Configurator.Order 'Bestellen' %></a>
						</div>
					</div>
				</div>
			</div> --%>
		</div>
	</section>