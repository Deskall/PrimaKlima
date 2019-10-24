
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
						
						
							<div class="uk-padding-small" data-uk-slider="index:1;">

							    
							    	<div class="uk-slider-container">
								        <ul class="uk-slider-items uk-child-width-3-4 uk-grid-match">
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

							    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
							</div>
						
						<div class="not-included-input">
							<input id="no-{$ID}" name="no-{$ID}" type="checkbox" class="uk-checkbox">
							<label for="no-{$ID}"><%t Category.NotIncluded 'Keine {title} Angebot' title=$Title %></label>
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