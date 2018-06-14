<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	 $HTML
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<% if Collapsible %>
<ul uk-accordion="<% if MultipleCollapse %>multiple: true<% end_if %>">
	<% loop Items %>
    <li <% if not collapsed %>class="uk-open"<% end_if %>>
        <a class="uk-accordion-title $TitleAlign" href="#">$Title</a>
        <div class="uk-accordion-content">
        	<div class="uk-grid-small uk-flex <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
	        	    <% if Image %>
	        	    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
	        	    	<% if Image.getExtension == "svg" %>
	        				<img src="$Image.URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" width="150" height="100">
	        			<% else %>
	        				<img src="$Image.ScaleWidth(150).URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" width="150" height="100">
	        			<% end_if %> 
	        	    </div>
	        	    <% end_if %>
	        	    <div class="<% if Image %>uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l<% else %>uk-width-1-1<% end_if %>">
	        		    <div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	        		    	$Content
	        		    </div>
	        		    <% if LinkableLinkID > 0 %>
	        		    	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	        		    <% end_if %>
	        		 </div>
	            <% if LinkableLinkID > 0 %>
	            	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	            <% end_if %>
	        </div>

        </div>
        <% if Top.Divider %>
	       <hr class="uk-width-1-1">
	    <% end_if %>
    </li>
    <% end_loop %>
</ul>
<% else %>
<% loop Items %>
    <div class="uk-grid-small uk-flex <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
    <% if Image %>
    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
    	<% if Image.getExtension == "svg" %>
			<img src="$Image.URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" width="150" height="100">
		<% else %>
			<img src="$Image.ScaleWidth(150).URL" alt="$Up.AltTag($Image.Description, $Image.Name, $Title)" title="$Up.TitleTag($Image.Name,$Title)" width="150" height="100">
		<% end_if %> 
    </div>
    <% end_if %>
    <div class="<% if Image %>uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l<% else %>uk-width-1-1<% end_if %>">
	    <div  class="$TitleAlign"><strong>$Title</strong></div>
	    <div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	    	$Content
	    </div>
	    <% if LinkableLinkID > 0 %>
	    	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	    <% end_if %>
	 </div>
	 <% if Top.Divider %>
	 <hr class="uk-width-1-1">
	 <% end_if %>
   </div>
 <% end_loop %>
<% end_if %>