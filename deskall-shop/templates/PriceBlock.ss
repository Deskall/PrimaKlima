
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$Lead
	</div>
</div>

<div class="uk-child-width-1-4@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
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
	        	<div class="product-price uk-text-large uk-text-bold">$Price</div>
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
