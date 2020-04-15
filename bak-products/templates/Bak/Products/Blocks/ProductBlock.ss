<ul data-uk-tab class="uk-margin-remove uk-child-width-expand">
    <li <% if Top.ShowCategories %> class="uk-active"<% end_if %>><a href="produkte/kategorie"  data-show-filter="categories" data-filter-name="Kategorie" class="uk-width-1-1"><%t ProductOverviewPage.KATEGORIE "Kategorie" %><span class="uk-position-center-right uk-position-small"><i class="icon ion-ios-arrow-down"></i></span></a></li>
    <li <% if Top.ShowUsages %> class="uk-active"<% end_if %>><a href="produkte/anwendung"  data-show-filter="usages" data-filter-name="Anwendung" class="uk-width-1-1"><%t ProductOverviewPage.ANWENDUNG "Anwendung" %><span class="uk-position-center-right uk-position-small"><i class="icon ion-ios-arrow-down"></i></span></a></li>
    <li><a class="uk-width-1-1"><input data-search-products placeholder="<%t ProductOverviewPage.Name 'Name' %>" /><span class="uk-position-center-right uk-position-small"><i class="icon ion-ios-search"></i></span></a></li>
</ul>
<ul id="products-switcher" class="uk-switcher">
    <li class="SecondaryBackground" data-filter-list>
    	<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-padding-small" data-uk-grid data-uk-height-match="h3">
    		<% loop getCategories %>
    		<div>
    			<h3  class="uk-margin-remove">$Title</h3>
    			<% if $ProductCategoryImage %>
    			  <img src="$ProductCategoryImage.FocusFillMax(350,250).URL" alt="$Title" class="uk-width-1-1  uk-margin-small-bottom" />
    			<% end_if %>
    			<div class="uk-text-right uk-margin-top">$Title <span class="icon ion-ios-arrow-right"></span></div>
		    </div>
		    <% end_loop %>
	    </div>
    </li>
    <li class="SecondaryBackground" data-filter-list>
    	<div class="uk-child-width-1-1 uk-padding-small" data-uk-grid>
    		<% loop getUseArea %>
    		<div>
    			<h2>$Title</h2>
		    	<div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid>
		    		<% loop Usages %>
		    		<div>
		    			<a href="$Link($Top.Top.Locale)" class="col w-4" data-filter-name="$UseArea.Title">
		    			  <div class="box clearfix">
		    			    <% if $Image %>
		    			        <img src="$Image.FocusFillMax(350,250).URL" alt="$Title" class="uk-width-1-1 uk-margin-small-bottom" />
		    			    <% end_if %>
		    			        $Description
		    			        <div class="uk-text-right uk-margin-top"><%t ProductOverviewPage.PRODUKTE "Passende Produkte" %> <span class="icon ion-ios-arrow-right"></span></div>
		    			    </div>
		    			</a>
		    		</div>
		    		<% end_loop %>
		    	</div>
		    </div>
		    <% end_loop %>
	    </div>
	</li>
    <li>
    	<div data-product-list class="product-list uk-padding-small" data-no-products-found="<%t ProductOverviewPage.NOPRODUCTS "Keine Produkte gefunden" %>">
    	  <a href="javascript: history.back()" class="close-products"></a>
    	  <div class="holder"></div>
    	</div>
    </li>
</ul>

<%-- <script id="products-template" type="text/x-handlebars-template">
    {{#if products}}
        {{#each products}}
            <div class="product">
                <div data-uk-grid>
                    <div class="uk-width-1-4@m">
                        <a href="{{link}}"><img src="{{img}}" alt="{{name}}" /></a>
                    </div>
                    <div class="uk-width-3-4@m">
                        <h3>{{name}}</h3>
                        {{#if description}}
                        <p class="description">{{description}}</p>
                        {{else}}
                            {{#if features}}
                            <p class="description">{{features}}</p>
                            {{/if}}
                            {{#if number}}
                            <p class="description">{{number}}</p>
                            {{/if}}
                        {{/if}}
                        <div class="uk-text-right">
                            <a href="{{link}}">{{linkText}}<span class="icon ion-ios-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        {{/each}}
    {{else}}
        <div class="product"><h3><%t ProductOverviewPage.NOPRODUCTS "Keine Produkte gefunden" %></h3></div>
    {{/if}}
</script> --%>