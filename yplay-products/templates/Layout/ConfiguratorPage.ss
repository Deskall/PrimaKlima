
	$ElementalArea
	
	<section class="uk-section uk-section-medium">
		<div class="uk-container uk-container-medium">
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
					<div id="modal-category-{$Code}" class="uk-modal-full" data-uk-modal>
					    <div class="uk-modal-dialog">
					        <button class="uk-modal-close-full uk-close-large" type="button" data-uk-close></button>
					        <div class="uk-modal-header">
					            <h2 class="uk-modal-title">$Title</h2>
					        </div>
					        <div class="uk-modal-body" data-uk-overflow-auto>
						        <div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle uk-grid-match" data-uk-grid>
						            <div class="uk-background-cover uk-height-1-1" style="background-image: url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');"></div>
						            <div class="uk-padding-large">
						                <h1>Headline</h1>
						                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						            </div>
						        </div>
					    	</div>
					        <div class="uk-modal-footer">
					        	<button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
					        </div>
					    </div>
					</div>
					<% end_loop %>
				</div>
				<div class="uk-width-expand">
					<div data-uk-sticky="media:640">
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
		</div>
	</section>