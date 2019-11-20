
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description" >
					<img src="<% if ContentImage.getExtension == "svg" %>$ContentImage.URL<% else %>$ContentImage.ScaleWidth(350).URL<% end_if %>" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
				</a>
			</div>
			<div class="dk-text-content uk-width-2-3@m <% if Layout == "right" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% else %>
			<div class="uk-width-1-1">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description">
					<% if $FullWidth %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
						<% else %>
							<%-- $ContentImage.Content($ContentImage.ID,2500,$Title) --%>
							<img src="$ContentImage.FitMax(1500,1500).URL" data-src="$ContentImage.FitMax(500,500).URL"
							     data-srcset="$ContentImage.FitMax(500,500).URL 500w,
							                  $ContentImage.FitMax(1000,1000).URL 1000w,
							                  $ContentImage.FitMax(1500,1500).URL 1500w,
							                  $ContentImage.FitMax(2500,2500).URL 2500w"
							     sizes="(min-width: 1700px) 2500px,(min-width: 1000px) 1500px,(min-width: 650px) 1000px, 100vw"  alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" data-uk-img>
						<% end_if %>
					<% else %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
						<% else %>
							<%-- $ContentImage.Content($ContentImage.ID,1200,$Title) --%>
							<img src="$ContentImage.FitMax(1500,1500).URL" data-src="$ContentImage.FitMax(500,500).URL"
							     data-srcset="$ContentImage.FitMax(500,500).URL 500w,
							                  $ContentImage.FitMax(1000,1000).URL 1000w,
							                  $ContentImage.FitMax(1500,1500).URL 1200w"
							     sizes="(min-width: 1200px) 1200px,(min-width: 650px) 1000px, 100vw" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" data-uk-img>
						<% end_if %>
					<% end_if %>

				</a>
			</div>
			<div class="dk-text-content uk-width-1-1 <% if Layout == "above" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% end_if %>
	<% else %>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	<% end_if %>
</div>

<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-flex-center uk-text-center uk-grid-match products-container" data-uk-grid data-dk-height-match=".product-body">
<% loop filteredItems %>
    <div class="uk-transition-toggle">
    	
        <div class="uk-card uk-card-default uk-border-rounded uk-card-body uk-box-shadow-medium uk-transition-scale-up uk-transition-opaque uk-position-relative">
	        
	        <h3 class="uk-card-title">$Title</h3>
	        <% if BestSeller %>
	        <div class="bestseller">Bestseller</div>
	        <% end_if %>
	        <div class="product-body">
	        	<% if Top.ProductType == "products" %>
			        <% loop $Items %>
			        <div class="product-item">
			       	 <strong>$Title</strong>
			       	 $Content
			       	</div>
			        <% end_loop %>
		        <% else_if Top.ProductType == "packages" %>
		        	<% loop Products %>
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
	        		<a href="{$Top.getPage.ShopPage.Link}paket-bestellen/$ID" class="uk-button btn-order">Bestellen</a>
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


