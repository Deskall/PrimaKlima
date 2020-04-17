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
		            <div class="uk-margin">
		            	<div class="uk-child-width-1-2@s uk-grid-small uk-flex-middle" data-uk-grid>
		            		<div>
				              <table class="uk-table uk-table-justify uk-table-small">
				              	<tr><td><strong>Preis:</strong></td><td><strong>$Price.Nice</strong>	</td></tr>
				              	<tr><td>MwSt.:</td><td>{$Top.SiteConfig.MwSt}%</td></tr>
				              	<tr><td>Zuzüglich Porto und Verpackung</td><td>&nbsp;</td></tr>
				              </table>
				          	</div>
				          	<div>
				          		<div class="uk-margin"><a class="uk-button button-blau uk-width-1-1 add-to-cart" data-product-id="$ID"><i class="uk-margin-small-right" data-uk-icon="cart"></i><%t Webshop.ToCart 'in den Warenkorb' %></a></div>
				          		<%-- <div class="uk-margin">agb, konditionen</div> --%>
				          	</div>
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
			
		