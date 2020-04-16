
	$ElementalArea

	<div class="element  bak__products__blocks__productblock" id="bakproductsblocksproductblock-0">
	
		<section class="uk-section  uk-section-small">
					
			<div class="uk-container uk-text-left ">
				<div class="uk-child-width-1-1 uk-grid-small uk-grid uk-grid-stack" data-uk-grid="">
					<div class="uk-width-1-1 uk-first-column">
						<div class="uk-panel">
							<div class="product-filter-holder uk-flex">
							  <a data-show-filter="categories" href="<% if $Locale = "de_DE"%>produkte/kategorie<% else_if $Locale == "es_ES" %>productos/categoría<% else %>products/category<% end_if %>" data-filter-name="<%t ProductOverviewPage.KATEGORIE "Kategorie" %>" class="head <% if ShowCategories %>active<% end_if %>"><% if SelectedCategory %>$SelectedCategory.Title<% else %><%t ProductOverviewPage.KATEGORIE "Kategorie" %><% end_if %></a>
							  <a data-show-filter="usages" href="<% if $Locale = "de_DE"%>produkte/anwendung<% else_if $Locale == "es_ES" %>productos/uso<% else %>products/application<% end_if %>" data-filter-name="<%t ProductOverviewPage.ANWENDUNG "Anwendung" %>" class="head <% if ShowUsages %>active<% end_if %>"><% if SelectedUsage %>$SelectedUsage.Title<% else %><%t ProductOverviewPage.ANWENDUNG "Anwendung" %><% end_if %></a>
							  <span class="head search <% if showProducts %>active<% end_if %>"><input data-search-products placeholder="<%t ProductOverviewPage.Name 'Name' %>" /></span>
							</div>

							<div data-product-list class="product-list" data-no-products-found="<%t ProductOverviewPage.NOPRODUCTS "Keine Produkte gefunden" %>">
							  <a data-close-products class="close-products"></a>
							  <div class="holder uk-padding uk-padding-remove-horizontal"></div>
							</div>

							<div data-filter-list="categories" class="filter-list uk-clearfix <% if ShowCategories %>active<% end_if %> SecondaryBackground uk-padding-small">

							   <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-padding-small uk-padding-top-large" data-uk-grid data-uk-height-match="h3">
							            <% loop getCategories %>
							            <div>
							                <a href="$Link($Top.Locale)" class="uk-display-block" data-filter-name="$Title">
							                <h3 class="uk-margin-remove">$Title</h3>
							                <% if $ProductCategoryImage %>
							                  <img src="$ProductCategoryImage.FocusFillMax(350,250).URL" alt="$Title" class="uk-width-1-1  uk-margin-small-bottom" />
							                <% end_if %>
							                <div class="uk-text-right uk-margin-top">$Title <span class="icon ion-ios-arrow-right"></span></div>
							                </a>
							            </div>
							            <% end_loop %>
							        </div>

							</div>

							<div data-filter-list="usages" class="filter-list uk-clearfix  <% if ShowUsages %>active<% end_if %> SecondaryBackground uk-padding-small">
							    <div class="uk-child-width-1-1 uk-padding-small" data-uk-grid>
							            <% loop getUseArea %>
							            <div>
							                <h2>$Title</h2>
							                <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid>
							                    <% loop Usages %>
							                    <div>
							                        <a href="$Link($Top.Locale)" class="col w-4" data-filter-name="$UseArea.Title">
							                          <div class="box uk-clearfix">
							                            <% if $Image %>
							                                <img src="$Image.FocusFillMax(350,250).URL" alt="$Title" class="uk-width-1-1 uk-margin-small-bottom" />
							                            <% end_if %>
							                                $Description
							                                <div class="uk-text-right uk-margin-top"><%t ProductOverviewPage.PRODUKTE "Passende Produkte" %> <span class="icon ion-ios-arrow-right"></span></div>
							                            </div>
							                        </a>
							                    </div>
							                    <% end_loop %>
							                </div>
							            </div>
							            <% end_loop %>
							        </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<% if $ID < 0 %> 
		<% if Form || Content %>
		<section class="uk-section">
			<div class="uk-container">
				<h1>$Title</h1>
				$Content
				$Form
			</div>
		</section>
		<% end_if %>
	<% end_if %>
	