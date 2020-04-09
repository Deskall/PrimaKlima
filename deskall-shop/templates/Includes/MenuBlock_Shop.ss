
<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	
			        <ul class="uk-navbar-nav">
				        <li>
				           	<a id="toggle-cart" data-uk-toggle="target: #cart-container" <% if $activeCart.countProducts == 0 %>hidden<% end_if %>>Warenkorb ( <small id="cart-articles-count">$activeCart.countProducts</small> )<span class="uk-margin-small-left" data-uk-icon="icon: cart"></span></a>
				           	<a id="link-shop" href="$ShopPage.Link" <% if $activeCart.countProducts > 0 %>hidden<% end_if %>>Warenkorb<span class="uk-margin-small-left" data-uk-icon="icon: cart" ></span></a>
				        </li>
			        </ul>
		
</div>


