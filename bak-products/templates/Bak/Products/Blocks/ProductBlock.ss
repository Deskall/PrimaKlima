<ul data-uk-tab class="uk-margin-remove uk-child-width-expand">
    <li><a href="#"><%t ProductOverviewPage.KATEGORIE "Kategorie" %></a></li>
    <li><a href="#"><%t ProductOverviewPage.ANWENDUNG "Anwendung" %></a></li>
    <li><input data-search-products placeholder="<%t ProductOverviewPage.Name 'Name' %>" /></li>
</ul>

<ul class="uk-switcher SecondaryBackground">
    <li>
    	<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-padding-small" data-uk-grid data-uk-height-match="h3">
    		<% loop getCategories %>
    		<div>
    			<h3  class="uk-margin-remove">$Title</h3>
    			<% if $ProductCategoryImage %>
    			  <img src="$ProductCategoryImage.FocusFillMax(350,250).URL" alt="$Title" class="uk-width-1-1" />
    			<% end_if %>
    			<div class="uk-text-right uk-margin-top">$Title <span class="icon ion-ios-arrow-right"></span></div>
		    </div>
		    <% end_loop %>
	    </div>
    </li>
    <li>
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
		    			        <img src="$Image.FocusFillMax(350,250).URL" alt="$Title" class="uk-width-1-1" />
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
    <li></li>
</ul>