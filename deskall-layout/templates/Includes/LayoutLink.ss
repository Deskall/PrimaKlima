<li data-level="$Level">
	<% with LinkableLink %>
	    <% if $LinkURL %>
	     	<a  href="$LinkURL" {$TargetAttr} <% if $Background %>class="uk-button button-{$Background}"<% end_if %>>
                <% if hasIcone %>
                <% if $Icone %><span class="uk-margin-small-right" data-uk-icon="icon:  $Icone;"></span><% end_if %> 
	            <span class="dk-link-with-icon">$Title</span>
                <% else %>
                $Title
                <% end_if %>
	        </a>
	    <% end_if %>
	<% end_with %>
    <% if ShowSubLevels && Children %>
    		<div class="uk-navbar-dropdown uk-margin-remove $DropdownType">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                	<% loop Children %>
                	  $forTemplate
                	<% end_loop %>
                </ul>
            </div>
    <% end_if %>
</li>