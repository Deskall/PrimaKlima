
<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	
			        <ul class="uk-navbar-nav">
				        <li>
				           	<% if $activeCart.countProducts > 0 %>
				           		<a id="toggle-cart" data-uk-toggle="target: #offcanvas-usage-cart">Warenkorb ( <small id="cart-articles-count">$activeCart.countProducts</small> )<span class="uk-margin-small-left" data-uk-icon="icon: cart"></span></a>
				           	<% else %>
				           		<a href="$ShopPage.Link">Warenkorb<span class="uk-margin-small-left" data-uk-icon="icon: cart"></span></a>
				           	<% end_if %>
				        </li>
			        </ul>
		
</div>
<% if activeCart %>
<% with activeCart %>
<% include ShopCart %>
<% end_with %>
<% end_if %>
