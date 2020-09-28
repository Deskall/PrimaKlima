
<div class="category uk-text-center $category.Code uk-margin-large <% if disabled || unavailable %>disabled<% end_if %>" <% if disabled || unavailable %>data-disabled<% end_if %> <% if mandatory %>data-mandatory<%end_if %> <% if $activeDependencies %>data-dependencies='$activeDependencies'<% end_if %>>
	<div class="uk-flex uk-flex-middle uk-flex-center uk-margin-small-bottom"><img src="$category.Icon.URL" width="50" class="uk-margin-small-right" alt="$category.Icon.Alt"><h3 class="uk-margin-remove uk-flex uk-flex-middle">$category.Title <% if not mandatory && not unavailable %><label class="switch uk-margin-small-left"><span class="slider round"></span></label><% end_if %></h3></div>
	<% if $unavailable %>
	<p><%t SHOP.CATEGORYUNAVAILABLE '{title} ist für die gewünschte Ortschaft nicht verfügbar' title=$category.Title %></p>
	<% else %>
	$category.Description
	<div id="category-{$category.ID}" class="uk-padding-small <% if $category.Code != "yplay-mobile" %>slider-packages<% end_if %> slider-products uk-padding-remove-bottom" data-id="$category.activeIndex" data-code="$category.Code">


		<div class="uk-slider-container">
			<ul class="uk-slider-items uk-child-width-2-3 uk-child-width-1-2@s uk-grid-match">
				<% loop $category.filteredProducts %>
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
		<a data-uk-toggle="#modal-category-{$category.Code}">Mehr erfahren</a>
	</div>
	<% if not $mandatory %>
	<div class="not-included-input">
		<input id="no-{$category.ID}" name="no-{$category.ID}" type="checkbox" class="uk-checkbox no-category" <% if not $category.Preselected %>checked="checked"<% end_if %>>
		<label for="no-{$category.ID}"><%t Category.NotIncluded 'Keine {title} Angebot' title=$category.Title %></label>
	</div>
	<% end_if %>
	<input type="hidden" name="$category.Code" data-product-choice>
	<% end_if %>
</div>
<% with category %>
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
<% end_with %>