<% if activeCart %>
<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	
			        <ul class="uk-navbar-nav">
				        <li>
				           	<a data-uk-toggle="target: #offcanvas-usage-cart">Warenkorb ( <small id="cart-articles-count">$activeCart.countProducts</small> )<span class="uk-margin-small-left" data-uk-icon="icon: cart"></span></a>
				        </li>
			        </ul>
		
</div>
<% include ShopCart %>
<% end_if %>
