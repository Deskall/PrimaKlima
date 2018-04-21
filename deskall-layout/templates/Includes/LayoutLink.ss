<li data-uk-icon="icon:  <% if $LinkableLink.Icone %>$LinkableLink.Icone;<% end_if %>" data-level="$Level">
	<% with LinkableLink %>
	    <% if $LinkURL %>
	     	<a href="$LinkURL" {$TargetAttr}>
	            $Title
	        </a>
	    <% end_if %>
	<% end_with %>
    <% if Children %>
    		<div class="uk-navbar-dropdown uk-margin-remove $DropdownType">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                	<% loop Children %>
                	  $forTemplate
                	<% end_loop %>
                </ul>
            </div>
    <% end_if %>
</li>