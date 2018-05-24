<div class="uk-grid-small uk-flex <% if ItemAlign == "right" %>uk-flex-row-reverse<% end_if %><% if Divider %>uk-grid-divider<% end_if %>" data-uk-grid>
    <% loop Items %>
    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
    	<% if Image.getExtension == "svg" %>
			<img src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="150" height="100">
		<% else %>
			<img src="$Image.ScaleWidth(150).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="150" height="100">
		<% end_if %> 
    </div>
    <div class="uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l ">
	    <strong class="$Top.TitleAlign">$Title</strong>
	    <div class="dk-text-content $Top.TextAlign  $Top.TextColumns">
	    	$Content
	    	<% if LinkableLinkID > 0 %>
	    		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	    	<% end_if %>
	    </div>
	 </div>
    <% end_loop %>
   </div>
