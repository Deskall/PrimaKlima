<div class="uk-grid-small" data-uk-grid>
    <% loop Items %>
    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
    	<% if Image.getExtension == "svg" %>
			<img src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="150" height="100">
		<% else %>
			$Image.Content($Image.ID,150,$Title)
		<% end_if %> 
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
