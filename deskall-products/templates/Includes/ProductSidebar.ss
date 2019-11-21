<div data-uk-sticky="bottom:true;bottom-offset:50;offset:100" data-test="$URLSegment">
					<ul class="uk-nav-default uk-background-muted uk-box-shadow-medium uk-nav-parent-icon" data-uk-nav="multiple: true">
						<li <% if not isAccount && ClassName == "ShopPage" && URLSegment == $MainShopPage.URLSegment%>class="uk-active"<% end_if %>><a href="$MainShopPage.Link" class="uk-h3 "><% if not isAccount && ClassName == "ShopPage" && URLSegment == $MainShopPage.URLSegment%><h1>$MainShopPage.MenuTitle</h1><% else %>$MainShopPage.MenuTitle<% end_if %></a></li>
						<li <% if isAccount %>class="uk-active"<% end_if %>><a href="shop/mein-konto" rel="noopener noreferrer nofollow"><% if isAccount %><h1><%t Shop.isAccount 'Mein Konto' %></h1><% else %><%t Shop.isAccount 'Mein Konto' %><% end_if %></a></li>
					    <% loop activeCategories %>
					    <li class="<% if Top.Product %><% if URLSegment == $Top.Product.Category.URLSegment %>uk-active<% end_if %><% else_if Top.Category %><% if URLSegment == $Top.Category.URLSegment %>uk-active<% end_if %><% end_if %> <% if SubCategories.exists %>uk-parent<% end_if %>"><a href="$Link" >$MenuTitle</a>
					    	<% if SubCategories.exists %>
					    	<ul class="uk-nav-sub">
					    	<% loop SubCategories %>
					    		 <li class="<% if Top.Product %><% if URLSegment == $Top.Product.Category.URLSegment %>uk-active<% end_if %><% else_if Top.Category %><% if URLSegment == $Top.Category.URLSegment %>uk-active<% end_if %><% end_if %>"><a href="$Link" >$MenuTitle</a></li>
					    	<% end_loop %>
					    	</ul>
					    	<% end_if %>
					    </li>
					    <% end_loop %>
					</ul>
				</div>