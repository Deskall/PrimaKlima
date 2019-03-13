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
        <a class="uk-accordion-title $TitleAlign">$CategoryTitle</a>
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
	<% loop Dishes.groupedBy(CategoryTitle) %>
    
       $CategoryTitle
        
        	<div class="uk-grid-small uk-flex uk-flex-middle <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
        		<% loop Children %>
	        	<% end_loop %>
	        </div>

      
        <% if Top.Divider %>
	       <hr class="uk-width-1-1">
	    <% end_if %>
 
    <% end_loop %>
<% end_if %>