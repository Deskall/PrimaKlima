<% with Product %>
<section class="uk-section">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb">
			    <li><a href="/webshop">Bewusstsein Leben Shop</a></li>
			    <li><a href="$Category.Link">$Category.Title</a></li>
			    <li><span>$Title</span></li>
			</ul>
		</div>
		<h1>$Title</h1>
		<div data-uk-grid>
		    <div class="uk-width-1-3@m uk-text-center">
		          <div class="uk-position-relative uk-height-medium" data-uk-slideshow="animation: fade;min-height:350;ratio:false;">

		              <ul class="uk-slideshow-items"  data-uk-lightbox="$ID">
		                <% with MainBild %>
		                  <li>
		                    <a href="$URL" class="uk-display-block uk-height-1-1">
		                        <img src="$FocusFill(350,350).URL" alt="" class="uk-border-circle">
		                    </a>
		                  </li>
		                  <% end_with %>
		                  <% loop Images.sort('Sort') %>
		                  <li>
		                    <a href="$URL" class="uk-display-block uk-height-1-1">
		                        <img src="$FocusFill(350,350).URL" alt="" class="uk-border-circle" >
		                    </a>  
		                  </li>
		                  <% end_loop %>
		              </ul>
		              <% if Images.count > 1 %>
		              
		             <div class="uk-margin-small-top uk-flex uk-flex-center uk-visible@s">
		                  <ul class="uk-thumbnav">
		                    <% with MainBild %>
		                      <li data-uk-slideshow-item="0"><a href="#"><img src="$FocusFill(100,100).URL" width="100" height="100" alt="" class="uk-border-circle"></a></li>
		                      <% end_with %>
		                      <% loop Images.sort('Sort') %>
		                      <li data-uk-slideshow-item="$pos"><a href="#"><img src="$FocusFill(100,100).URL" width="100" height="100" alt="" class="uk-border-circle"></a></li>
		                      <% end_loop %>
		                  </ul>
		              </div>
		              <% end_if %>
		          </div>
		    </div>
		    <div class="uk-width-2-3@m">
		        	<% if Lead %>
		        		<div class="uk-margin">$Lead</div>
		        	<% end_if %>
		        	<% if Description %>
		        		<div class="uk-margin">$Description</div>
		        	<% end_if %>
		            <div class="uk-margin">
		            	<div class="uk-child-width-1-2@s uk-grid-small" data-uk-grid>
		            		<div>
				              <table class="uk-table uk-table-justify uk-table-small">
				              	<tr><td>Preis:</td><td>$Price.Nice</td></tr>
				              	<tr><td>MwSt.:</td><td>7.7%</td></tr>
				              	<tr><td>Zuzüglich Porto und Verpackung</td><td>&nbsp;</td></tr>
				              </table>
				          	</div>
				          	<div>
				          		<div class="uk-margin"><a class="uk-button button-SecondaryBackground uk-width-1-1 uk-border-rounded add-to-cart" data-product-id="$ID"><i class="uk-margin-small-right" data-uk-icon="cart"></i><%t Webshop.ToCart 'in den Warenkorb' %></a></div>
				          		<div class="uk-margin">agb, konditionen</div>
				          	</div>
		            	</div>
		        	</div>
		    </div>
		</div>
		<div class="uk-margin uk-text-center">
			$Top.SiteConfig.FootertextProduct
		</div>
	</div>
</section>
<% end_with %>

			
		