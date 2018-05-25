<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	 $HTML
</div>
<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
<% if Collapsible %><div data-uk-accordion><% end_if %>
<% loop Items %>
    <div class="uk-grid-small uk-flex <% if Layout == "right" %>uk-flex-row-reverse<% end_if %> <% if not Collapsed %>uk-open<% end_if%>" data-uk-grid >
    <% if Top.Collapsible %><div class="uk-width-1-1"><div  class="$TitleAlign uk-accordion-title"><strong>$Title</strong></div></div>
    <div class="uk-accordion-content">
    <% end_if %>

    <% if Image %>
    <div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
    	<% if Image.getExtension == "svg" %>
			<img src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="150" height="100">
		<% else %>
			<img src="$Image.ScaleWidth(150).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="150" height="100">
		<% end_if %> 
    </div>
    <% end_if %>
    <div class="<% if Image %>uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l<% else %>uk-width-1-1<% end_if %>">
	    <% if not Top.Collapsible %><div  class="$TitleAlign"><strong>$Title</strong></div><% end_if %>
	    <div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	    	$Content
	    </div>
	    <% if LinkableLinkID > 0 %>
	    	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
	    <% end_if %>
	 </div>
	 <% if Top.Collapsible %></div><% end_if %>
	 <% if Top.Divider %>
	 <hr class="uk-width-1-1">
	 <% end_if %>
   </div>
 <% end_loop %>
 <% if Collapsible %></div><% end_if %>