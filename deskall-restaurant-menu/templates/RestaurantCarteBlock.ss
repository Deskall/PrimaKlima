<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	 $HTML
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<% if Collapsible %>
<ul uk-accordion="<% if MultipleCollapse %>multiple: true<% end_if %>">
	<% loop Dishes.groupedBy(CategoryTitle) %>
    <li class="list-item uk-margin-top <% if not collapsed %>uk-open<% end_if %>">
        <a class="uk-accordion-title $TitleAlign"><h3>$CategoryTitle</h3></a>
        <div class="uk-accordion-content">
        	<div class="uk-grid-small uk-flex uk-flex-middle <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
        		<% loop Children %>
	        	<% end_loop %>
	        </div>

        </div>
        <% if Top.Divider %>
	       <hr class="uk-width-1-1">
	    <% end_if %>
    </li>
    <% end_loop %>
</ul>
<% else %>
<div class="uk-child-width-1-1" data-uk-grid >
	<% loop Dishes.groupedBy(CategoryTitle) %>

        <div id="$CategoryTitle.URLATT">
           <h3>$CategoryTitle</h3>
            
            	<div class="uk-grid-small uk-flex uk-flex-middle uk-child-width-1-1 <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
            		<% loop Children %>
            		<div>
            			<% if Description %>
            			<strong class="uk-clearfix">$Title:</strong>
            			<div class="uk-grid-small" data-uk-grid>
    					    <div class="uk-width-expand" data-uk-leader>$PrintDescription</div>
    					    <div>$PrintPrice</div>
    					</div>
            			<% else %>
            			<div class="uk-grid-small" data-uk-grid>
    					    <div class="uk-width-expand" data-uk-leader>$Title</div>
    					    <div>$PrintPrice</div>
    					</div>
            			<% end_if %>
            		</div>
    	        	<% end_loop %>
    	        </div>

          
            <% if Top.Divider %>
    	       <hr class="uk-width-1-1">
    	    <% end_if %>
        </div>
    <% end_loop %>
</div>
<% end_if %>

<div class="uk-position-fixed uk-position-center-right-out">
    <ul class="uk-nav">
       <% loop Dishes.groupedBy(CategoryTitle) %>
       <li><a href="#{$CategoryTitle.URLATT}">$CategoryTitle</a></li>
        <% end_loop %>
   </ul>
</div>