
	$ElementalArea
	
	<section class="uk-section uk-section-medium">
		<div class="uk-container uk-container-medium">
			<h2><%t Configurator.Title 'Wählen Sie Ihr Paket' %></h2>
			<div data-uk-grid>
				<div class="uk-width-2-3@m uk-width-3-4@l">
					<% loop activeCategories %>
					<div class="category uk-text-center $Code">
						<h3><img src="$Icon.URL" width="50">$Title</h3>
						
						$Description
						
						
							<div data-uk-slider="center:true;index:1;">

							    <div class="uk-position-relative" tabindex="-1">
							    	<div class="uk-slider-container">
								        <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">
								            <% loop Products %>
								            <li>
								                <div class="uk-card uk-card-default uk-border-rounded uk-card-hover uk-box-shadow-small">
								                    <div class="uk-card-media-top">
								                        <img src="$Image.URL" alt="">
								                    </div>
								                    <div class="uk-card-body">
								                        <h3 class="uk-card-title">$Title</h3>
								                        $Subtitle
								                    </div>
								                </div>
								            </li>
								            <% end_loop %>
								        </ul>
								    </div>

							        <a class="uk-position-center-left-out uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
							        <a class="uk-position-center-right-out uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slider-item="next"></a>

							    </div>

							    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
							</div>
						
						<div class="not-included-input">
							<input id="no-{$ID}" name="no-{$ID}" type="checkbox">
							<label for="no-{$ID}"><%t Category.NotIncluded 'Keine {title} Angebot' title=$Title %></label>
						</div>
					</div>
					<% end_loop %>
				</div>
				<div class="uk-width-expand">
					<div data-uk-sticky>
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