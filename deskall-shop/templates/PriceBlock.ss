
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$Lead
	</div>
</div>
<div data-uk-slider="center:true;index:2;">
	<div class="uk-position-relative uk-padding-small uk-visible-toggle" tabindex="-1" data-uk-height-match=".uk-card-title">
		<ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-4@l uk-grid uk-grid-match products-container">
			<% loop activePackages %>
			    <li class="dk-transition-toggle-not-mobile">
			    	
			        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative uk-text-center uk-card-small">
				        
				        <h3 class="uk-card-title">$Title</h3>
				        <div class="product-body">
				        	<div class="uk-margin">$RunTimeTitle</div>
				        	<div class="uk-margin">$NumOfAdsTitle</div>
				        	<% loop $Features %>
				        	<div class="uk-margin">$Title</div>
				        	<% end_loop %> 
				        	<% if PackegeOptions %>
					        	<table class="uk-flex uk-flex-center"><% loop PackegeOptions %>
					        		<tr><td>$Title</td><td>$Price €</td></tr>
					        		<% end_loop %>
					        	</table>
				        	<% else %>
				        	<div class="product-price uk-text-large uk-text-bold">$Price €</div>
				        	<% end_if %>
					    </div>
				        <div class="product-footer uk-position-bottom">
					        <div class="uk-margin">
				        		<a href="$OrderLink" class="uk-button uk-button-primary"><%t Checkout.Order 'Bestellen' %><i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
				        	</div>
				        	<div class="footer-text">$FooterText</div>
				    	</div>
				    </div>
			    </li>
			<% end_loop %>
		</ul>
		<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
		<%-- <a class="uk-position-center-left-out uk-position-small uk-hidden-hover" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
		<a class="uk-position-center-right-out uk-position-small uk-hidden-hover" data-uk-slidenav-next data-uk-slider-item="next"></a> --%>
	</div>
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>