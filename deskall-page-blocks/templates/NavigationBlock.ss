

<div class="uk-flex <% if $TextAlign == "uk-text-left" %>uk-flex-left<% else_if $TextAlign == "uk-text-right"%>uk-flex-right<% else_if $TextAlign == "uk-text-center" %>uk-flex-center<% else %>uk-flex-between<% end_if %>" data-uk-margin data-uk-grid>
		<% loop Items %>
	    	<div class="uk-width-1-1 uk-width-auto@m">
	    		<% if ItemType == "block" || ItemType == "scrolltop" %> 
	    		<a href="#{$TargetLink}" class="uk-button button-{$BackgroundColor}" data-uk-scroll="offset:50">$NiceTitle</a>
	    		<% else_if ItemType == "target" %>
	    		<a data-uk-toggle="target: {$TargetLink}" class="uk-button  button-{$BackgroundColor}">$NiceTitle</a>
	    		<% else_if ItemType == "link" %>
			    	<% if LinkableLinkID > 0 %>
						<% with $LinkableLink %>
							<% if $LinkURL %>
							    <a href="$LinkURL" {$TargetAttr} class="uk-button  button-{$Up.BackgroundColor}" <% if hasIcone %>data-uk-icon="icon: $Icone"<% end_if %>>$Title</a>
							<% end_if %>
						<% end_with %>
					<% end_if %>
	    		<% end_if %>
	    	</div>
	   <% end_loop %>
	</div>