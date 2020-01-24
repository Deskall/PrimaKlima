
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$Lead
	</div>
</div>

<%-- <div class="uk-child-width-1-4@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
	<div>
		<div class="uk-card uk-card-body">
			<h3 class="uk-card-title">&nbsp;</h3>
			<div class="product-body uk-text-right">
			    <% loop activeParameters %>
				<div class="uk-margin uk-text-small">$Title</div>
				<% end_loop %>   	
			</div>
		</div>
	</div>
	<% loop activePackages %>
    <div class="dk-transition-toggle-not-mobile">
    	
        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative">
	        
	        <h3 class="uk-card-title">$Title</h3>
	        <div class="product-body">
	        	<% loop $Parameters %>
	        	<% if included %>
	        	<div class="uk-margin"><i class="icon icon-checkmark"></i></div>
	        	<% else %>
	        	<div class="uk-margin">-</div>
	        	<% end_if %>
	        	<% end_loop %>   
		    </div>
	        <div class="product-footer">
	        	<% if PackegeOptions %>
	        	<table><% loop PackegeOptions %>
	        		<tr><td>$Title</td><td>$Price €</td></tr>
	        		<% end_loop %>
	        	</table>
	        	<% else %>
	        	<div class="product-price uk-text-large uk-text-bold">$Price €</div>
	        	<% end_if %>
	        	<div class="uk-margin">
	        		<a href="$OrderLink" class="uk-button btn-order">Bestellen</a>
	        	</div>
	        	<div class="footer-text">$FooterText</div>
	    	</div>
	    </div>
    </div>
	<% end_loop %>
</div> --%>

<div class="uk-child-width-auto uk-child-width-1-5@l uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid>
<%-- 	<div>
		<div class="uk-card uk-card-body uk-padding-remove-horizontal">
			<h3 class="uk-card-title">&nbsp;</h3>
			<div class="product-body uk-text-right">
				<div class="uk-margin"><%t Package.RunTime 'Laufzeit' %></div>
				<div class="uk-margin"><%t Package.OfferQuota 'Anzahl Stelleninserate' %></div>
			    <% loop activeParameters %>
				<div class="uk-margin">$Title</div>
				<% end_loop %>   	
			</div>
		</div>
	</div> --%>
	<% loop activePackages %>
	    <div class="dk-transition-toggle-not-mobile">
	    	
	        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative<">
		        
		        <h3 class="uk-card-title">$Title</h3>
		        <div class="product-body">
		        	<div class="uk-margin"><span class="uk-hidden@m uk-margin-small-right"><%t Package.RunTime 'Laufzeit' %></span>$RunTimeTitle</div>
		        	<div class="uk-margin"><span class="uk-hidden@m uk-margin-small-right"><%t Package.OfferQuota 'Anzahl Stelleninserate' %></span>$NumOfAdsTitle</div>
		        	<% loop $Features %>
		        	<div class="uk-margin"><span class="uk-hidden@m uk-margin-small-right">$title</span>$Title</div>
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
	    </div>
	<% end_loop %>
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
