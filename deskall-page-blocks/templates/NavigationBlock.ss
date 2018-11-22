<ul class="uk-subnav" data-uk-margin>
	<% loop Items %>
    	<li class="uk-width-1-1 uk-width-auto@m">
    		<% if ItemType == "block" %> 
    		<a href="#{$TargetLink}" class="uk-button uk-button-small ActiveColor" data-uk-scroll="offset:50"><% if Title %>$Title<% else %>$Target.Title<% end_if %></a>
    		<% else_if ItemType == "target" %>
    		<a data-uk-toggle="target: {$TargetLink}" class="uk-button uk-button-small uk-button-secondary"><% if Title %>$Title<% else %>$Action.Title<% end_if %></a>
    		<% else_if ItemType == "link" %>
		    	<% if LinkableLinkID > 0 %>
					<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
				<% end_if %>
    		<% end_if %>
    	</li>
   <% end_loop %>
</ul>