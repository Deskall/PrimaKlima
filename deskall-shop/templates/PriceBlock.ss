
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$Lead
	</div>
</div>

<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
<% loop activePackages %>
    <div class="dk-transition-toggle-not-mobile">
    	
        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative">
	        
	        <h3 class="uk-card-title">$Title</h3>
	        <% if BestSeller %>
	        <div class="bestseller">Bestseller</div>
	        <% end_if %>
	        <% if hasAction %>
	        <div class="discount"><img src="$ThemeDir/img/percent-solid.svg" data-uk-svg></div>
	        <% end_if %>
	        <div class="product-body">
	        	<% if Top.ProductType == "products" %>
	        		<% if Subtitle %>
	        		$Subtitle
	        		<% end_if %>
	        		<% if Items.exist %>
				        <% loop $Items %>
				        <div class="product-item">
				       	 <strong>$Title</strong>
				       	 $Content
				       	</div>
				        <% end_loop %>
				    <% end_if %>
		        <% else_if Top.ProductType == "packages" %>
		        	<% loop activeProducts %>
		        	<div class="product-item">
		        		 <strong>$Title</strong>
		        		 <div>
		        			 $Subtitle
		        		 </div>
		        	</div>
		        	<% end_loop %>
		        <% end_if %>
		    </div>
	        <div class="product-footer">
	        	<div class="product-price uk-text-large uk-text-bold">$PrintPriceString</div>
	        	<div class="uk-margin">
	        		<a href="$OrderLink" class="uk-button btn-order">Bestellen</a>
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
