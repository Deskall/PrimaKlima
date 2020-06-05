

<ul class="uk-subnav" data-uk-margin>
		<% loop Items %>
	    	<li class="uk-width-1-1 uk-width-auto@m">
	    		<% if ItemType == "block" %> 
	    		<a href="#{$TargetLink}" class="uk-button button-{$BackgroundColor}" data-uk-scroll="offset:50"><% if Title %>$Title<% else %>$Target.Title<% end_if %></a>
	    		<% else_if ItemType == "target" %>
	    		<a data-uk-toggle="target: {$TargetLink}" class="uk-button  button-{$BackgroundColor}"><% if Title %>$Title<% else %>$Action.Title<% end_if %></a>
	    		<% else_if ItemType == "link" %>
			    	<% if LinkableLinkID > 0 %>
						<% with $LinkableLink %>
							<% if $LinkURL %>
							    <a href="$LinkURL" {$TargetAttr} class="uk-button  button-{$Up.BackgroundColor}" <% if hasIcone %>data-uk-icon="icon: $Icone"<% end_if %>>$Title</a>
							<% end_if %>
						<% end_with %>
					<% end_if %>
	    		<% end_if %>
	    	</li>
	   <% end_loop %>
	</ul>