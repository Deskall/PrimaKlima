<ul data-uk-tab>
    <li><a href="#"><%t ProductOverviewPage.KATEGORIE "Kategorie" %></a></li>
    <li><a href="#"><%t ProductOverviewPage.ANWENDUNG "Anwendung" %></a></li>
    <li><input data-search-products placeholder="<%t ProductOverviewPage.Name 'Name' %>" /></li>
</ul>

<ul class="uk-switcher uk-background-secondary">
    <li>
    	<div class="uk-child-width-1-1" data-uk-grid>
    		<% loop getCategories %>
    		<div>
    			<h3>$Title</h3>
    			<% if $ProductCategoryImage %>
    			  <img src="$ProductCategoryImage.FocusFillMax(350,250).URL" alt="$Title"/>
    			<% end_if %>
    			<div class="link-more">$Title <span class="icon ion-ios-arrow-right"></span></div>
		    </div>
		    <% end_loop %>
	    </div>
    </li>
    <li>
    	<div class="uk-child-width-1-1" data-uk-grid>
    		<% loop getCategories %>
    		<div>
    			<h2>$Title</h2>
		    	<div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid>
		    		<% loop Products %>
		    		<div>
		    			
		    		</div>
		    		<% end_loop %>
		    	</div>
		    </div>
		    <% end_loop %>
	    </div>
	</li>
    <li></li>
</ul>