<div class="uk-grid-small" data-uk-grid>
    <% loop Items %>
    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
    </div>
    <div class="uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l">
	    <strong>$Title</strong>
	    <div>$Content<br/>
	    	<% if LinkableLinkID > 0 %>
	    		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	    	<% end_if %>
	    </div>
	 </div>
    <% end_loop %>
   </div>
