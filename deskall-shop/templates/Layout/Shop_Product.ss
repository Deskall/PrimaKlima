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
		        <div class="uk-width-2-3@m">
		          <div class="uk-position-relative" data-uk-slideshow="animation: fade">

		              <ul class="uk-slideshow-items"  data-uk-lightbox="$ID">
		                <% with MainBild %>
		                  <li>
		                    <a href="$URL" class="uk-display-block uk-height-1-1">
		                        <img src="$ScaleWidth(500).URL" alt="" class="uk-border-circle">
		                    </a>
		                  </li>
		                  <% end_with %>
		                  <% loop Images.sort('Sort') %>
		                  <li>
		                    <a href="$URL" class="uk-display-block uk-height-1-1">
		                        <img src="$ScaleWidth(500).URL" alt="" class="uk-border-circle" >
		                    </a>  
		                  </li>
		                  <% end_loop %>
		              </ul>
		              <% if Images.count > 1 %>
		              
		             <div class="uk-margin-small-top uk-flex uk-flex-center uk-visible@s">
		                  <ul class="uk-thumbnav">
		                    <% with MainBild %>
		                      <li data-uk-slideshow-item="0"><a href="#"><img src="$CroppedFocusedImage(100,80).URL" width="100" height="80" alt="" class="uk-border-circle"></a></li>
		                      <% end_with %>
		                      <% loop Images.sort('Sort') %>
		                      <li data-uk-slideshow-item="$pos"><a href="#"><img src="$CroppedFocusedImage(100,80).URL" width="100" height="80" alt="" class="uk-border-circle"></a></li>
		                      <% end_loop %>
		                  </ul>
		              </div>
		              <% end_if %>
		          </div>
		        </div>
		        <div class="uk-width-1-3@m">
		            <div class="uk-margin">$Lead</div>
		            <div class="uk-margin uk-background-muted uk-padding-small">
		              <table class="uk-table uk-table-small">
		              	<tr><td>Preis:</td><td>$Price</td></tr>
		              	<tr><td>MwSt.:</td><td>7.7%</td></tr>
		              	<tr><td>Zuzüglich Porto und Verpackung</td><td>&nbsp;</td></tr>
		              </table>
		            </div>
		        </div>
		      </div>
	</div>
</section>
<% end_with %>