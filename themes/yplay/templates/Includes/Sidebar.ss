<% if $LateralSections.exists || activeCart.exists %>
<div class="uk-position-fixed uk-position-center-right uk-position-z-index sidebar-menu">
	<% if $activeCart.exists && $ClassName != "ShopPage" && $ClassName != "ConfiguratorPage"  %>
	<button class="uk-button uk-visible@m" type="button" data-uk-toggle="target: #offcanvas-usage-cart">Warenkorb<span class="uk-margin-small-left" data-uk-icon="icon: cart"></span></button>
	<div id="offcanvas-usage-cart" data-uk-offcanvas="flip:true;">
		<div class="uk-offcanvas-bar dk-middle-offcanvas cart-offcanvas">
			<button class="uk-offcanvas-close" type="button" data-uk-close></button>
			<div class="uk-card WhiteBackground uk-card-hover uk-box-shadow-medium uk-card-small">
				<div class="uk-card-header">
					<h3 class="uk-card-title"><%t Configurator.AboLabel 'Bestellübersicht' %></h3>
				</div>
				<div class="uk-card-body order-preview">
					<% with activeCart %>
					<% include ShopCart %>
					<% end_with %>
				</div>
				<div class="uk-card-footer">
					<a href="$ShopPage.Link" class="uk-button uk-button-primary"><%t Configurator.Order 'Bestellen' %></a>
				</div>
			</div>
		</div>
	</div>
	<% end_if %>
	<% loop LateralSections %>
	<button class="uk-button $ButtonFarbe" type="button" data-uk-toggle="target: #offcanvas-usage-{$ID}">$ButtonTitle<% if $ButtonIcon %><span class="uk-margin-small-left" data-uk-icon="icon: $ButtonIcon"></span><% end_if %></button>
	<div id="offcanvas-usage-{$ID}" data-uk-offcanvas="flip:true;">
		<div class="uk-offcanvas-bar dk-middle-offcanvas <% if ButtonFarbe %>$ButtonFarbe<% else %>default<% end_if %>">
			<button class="uk-offcanvas-close" type="button" data-uk-close></button>
			<h3>$Title</h3>
			$Text
			<ul class="uk-nav uk-padding-remove">
				<% loop Links %>
				<li>
					<div class="uk-grid-small" data-uk-grid>
						<% if Label %><div class="uk-width-1-5"><span class="uk-label $Background uk-margin-small-right uk-border-rounded">$Label</span></div><% end_if %>
						<div class="<% if Label %>uk-width-4-5<% else %>uk-width-1-1<% end_if %>">
							<a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr} <% if $LinkableLink.hasIcone %>data-uk-icon="icon: $LinkableLink.Icone"<% end_if %>>
								$LinkableLink.Title
							</a>
						</div>
					</div>
				</li>
				<% end_loop %>
			</ul>
		</div>
	</div>
	<% end_loop %>
</div>
<% end_if %>