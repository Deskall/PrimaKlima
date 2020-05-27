<% with Product %>
<% include HeaderSlide MenuTitle=$Title %>
<section class="uk-section uk-background-muted uk-padding-small">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb uk-margin-remove">
			    <li><a href="/webshop">Bewusstsein Leben Shop</a></li>
			    <li><a href="$Category.Link">$Category.Title</a></li>
			    <%-- <li><span>$Title</span></li> --%>
			</ul>
		</div>
	</div>
</section>
<section class="uk-section">
	<div class="uk-container">
		<h1 class="uk-text-nowrap uk-text-center uk-text-left@m">$Title</h1>
		<div class="uk-grid-small" data-uk-grid>
		    <div class="uk-width-1-3@m uk-text-center">
		          <div class="uk-position-relative" data-uk-slideshow="animation: fade;min-height:350;">

		              <ul class="uk-slideshow-items"  data-uk-lightbox="$ID">
		                <% with MainBild %>
		                  <li>
		                    <a href="$URL" class="uk-display-block">
		                        <img src="$FocusFill(350,350).URL" alt="" class="uk-border-circle">
		                    </a>
		                  </li>
		                  <% end_with %>
		                  <% loop Images.sort('Sort') %>
		                  <li>
		                    <a href="$URL" class="uk-display-block">
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
	        	<div class="uk-child-width-1-2@s uk-grid-small uk-flex-bottom product-form"  data-uk-grid>
	        		<div>
			        	<% if Variants.exists %>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Content 'Inhalt' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<select class="uk-select" name="variant">
				        				<% loop Variants %>
				        				<option value="$ID" data-title="$Title" data-price="$Price" data-stock="$Stock" <% if Default %>selected<% end_if %>>$Title - $Price.Nice</option>
				        				<% end_loop %>
				        			</select>
				        		</div>
				        	</div>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Quantity 'Menge' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<input class="uk-input" type="number" min="1" name="quantity" value="1" />
				        		</div>
				        	</div>
				        	<% with StandardVariant %>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Availability 'Lagerbestand' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<span id="availability"><% if $Stock == "onStock" %><span class="text-gruen">im Lager</span><% else %><span class="text-pink">Ausverkauft</span><% end_if %></span>
				        		</div>
				        	</div>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Price 'Preis' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<strong id="total-price" data-price="$Price">$Price.Nice</strong>
				        		</div>
				        	</div>
				        	<% end_with %>
				        <% else %>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Quantity 'Menge' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<input class="uk-input" type="number" min="1" name="quantity" value="1" />
				        		</div>
				        	</div>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Availability 'Lagerbestand' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<span id="availability"><% if $Stock == "onStock" %><span class="text-gruen">im Lager</span><% else %><span class="text-pink">Ausverkauft</span><% end_if %></span>
				        		</div>
				        	</div>
				        	<div class="uk-margin" data-uk-grid>
				        		<div class="uk-width-1-2 uk-width-1-3@m">
				        			<strong><%t Product.Price 'Preis' %></strong>
				        		</div>
				        		<div class="uk-width-1-2 uk-width-2-3@m">
				        			<strong id="total-price" data-price-standard="$Price">$Price.Nice</strong>
				        		</div>
				        	</div>
			        	<% end_if %>
			        	<div class="uk-margin" data-uk-grid>
			        		<div class="uk-width-1-2 uk-width-1-3@m">
			        			<strong><%t Product.VAT 'MwSt.:' %></strong>
			        		</div>
			        		<div class="uk-width-1-2 uk-width-2-3@m">
			        			{$Top.SiteConfig.MwSt}%
			        		</div>
			        	</div>
			            <div class="uk-margin">
			            	<div>
					            <%t Product.TransportCostLabel 'Zuzüglich Porto und Verpackung' %>
					        </div>
					    </div>
					</div>
		          	<div>
		          		<div class="uk-margin"><a class="uk-button button-blau uk-width-1-1 add-to-cart" data-product-id="$ID"><i class="uk-margin-small-right" data-uk-icon="cart"></i><%t Webshop.ToCart 'in den Warenkorb' %></a></div>
		          		<%-- <div class="uk-margin">agb, konditionen</div> --%>
		          	</div>
		        </div>
		    </div>
		</div>
	</div>
</section>
<% end_with %>
<section class="uk-section uk-background-muted uk-padding-small">
	<div class="uk-container">
		<div class="uk-text-center@m">
			$SiteConfig.FootertextProduct
		</div>
	</div>
</section>
			
		