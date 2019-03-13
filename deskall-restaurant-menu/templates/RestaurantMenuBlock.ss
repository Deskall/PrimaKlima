<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	 $HTML
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<div class="uk-grid-collapse" data-uk-grid>
    <div class="uk-width-1-1 uk-width-2-3@m uk-width-3-4@l uk-width-5-6@xl">
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
        <div class="uk-child-width-1-1 uk-grid-large" data-uk-grid >
        	<% loop Categories %>
                <% if Dishes.exists %>
                <div class="uk-margin-large">
                   <h3 id="c-$Pos">$Title</h3>
                    
                    	<div class="uk-grid-small uk-flex uk-flex-middle uk-child-width-1-1 <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
                    		<% loop Dishes %>
                    		<div>
                    			<% if Description %>
                    			<strong class="uk-clearfix">$Title:</strong>
                    			<div class="uk-grid-small" data-uk-grid>
            					    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
            					   <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
            					</div>
                    			<% else %>
                    			<div class="uk-grid-small" data-uk-grid>
            					    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
            					    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
            					</div>
                    			<% end_if %>
                    		</div>
                            <% if Subdishes.exists %>
                                <% loop Subdishes %>
                                <div>
                                    <% if Description %>
                                    <strong class="uk-clearfix">$Title:</strong>
                                    <div class="uk-grid-small" data-uk-grid>
                                        <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
                                        <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                                    </div>
                                    <% else %>
                                    <div class="uk-grid-small" data-uk-grid>
                                       <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
                                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                                    </div>
                                    <% end_if %>
                                </div>
                                <% end_loop %>
                            <% end_if %>
            	        	<% end_loop %>
            	        </div>

                  
                    <% if Top.Divider %>
            	       <hr class="uk-width-1-1">
            	    <% end_if %>
                </div>
                 <% end_if %>
            <% end_loop %>
        </div>
        <% end_if %>
    </div>
    <div class="uk-width-1-1 uk-width-1-3@m uk-width-1-4@l uk-width-1-6@xl uk-visible@m">
        <div class="uk-position-fixed uk-position-center-right">
            <%-- <div data-uk-sticky="offset:100;offsetBottom:50;bottom:true;"> --%>
                <div class="uk-margin-left">
                   <ul class="uk-nav uk-nav-default tm-nav" data-uk-scrollspy-nav="closest: li; scroll: true;offset:150">
                       <% loop Categories %>
                       <li><a href="#c-{$Pos}">$Title</a></li>
                        <% end_loop %>
                   </ul>
               </div>
            <%-- </div> --%>
        </div>
    </div>
</div>