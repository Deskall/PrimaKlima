
	<% with getPage %>
	<ul data-uk-accordion>
		<% loop Children %>
		    <li>
		        <a class="uk-accordion-title">$Title</a>
		        <div class="uk-accordion-content">
		        	<% with Elements.Elements.first %>
		        	    <div class="list-item uk-margin-top">
		        	        <a class="$TitleAlign">$Title</a>
		        	        $ID
		        	        <div>
		        	        	<div class="uk-grid-small uk-flex uk-flex-middle <% if Layout == "right" %>uk-flex-row-reverse<% end_if %>" data-uk-grid >
		        		        	    <% if ContentImage %>
		        		        	    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
		        		        	    	<% if ContentImage.getExtension == "svg" %>
		        		        				<img src="$ContentImage.URL" alt="$Up.AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$Up.TitleTag($ContentImage.Name,$Title)" class="svg-list-item">
		        		        			<% else %>
		        		        				<img src="$ContentImage.ScaleWidth(200).URL" alt="$Up.AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$Up.TitleTag($ContentImage.Name,$Title)" >
		        		        			<% end_if %> 
		        		        	    </div>
		        		        	    <% end_if %>
		        		        	    <div class="<% if ContentImage %>uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l<% else %>uk-width-1-1<% end_if %>">
		        		        		    <div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		        		        		    	$Content
		        		        		    </div>
		        		        		    <% if LinkableLinkID > 0 %>
		        		        		    	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		        		        		    <% end_if %>
		        		        		 </div>
		        		        </div>

		        	        </div>
		        	        
		        		    <hr class="uk-width-1-1">
		        	    </div>
		        	<% end_with %>
		        </div>
		    </li>
		<% end_loop %>
	</ul>
	<% end_with %>
