		<li data-uk-icon="icon:  <% if $Icon %>$Icon;<% end_if %>">
			<% with LinkableLink %>
		    <% if $LinkURL %>
		     	<a href="$LinkURL" {$TargetAttr}>
		            $Title
		        </a>
		    <% end_if %>
		    <% end_with %>
		</li>