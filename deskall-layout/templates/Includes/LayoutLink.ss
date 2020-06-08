<li data-level="$Level"  <% if LinkableLink.Embedded %>data-uk-lightbox <% end_if %>>
	<% with LinkableLink %>
	    <% if $LinkURL %>
	     	<a  href="$LinkURL" {$TargetAttr} <% if Rel %>rel="$Rel"<% end_if %> class="<% if $Background != "no-bg" %>uk-button button-{$Background}<% end_if %> <% if hasIcone %>dk-link-with-icon<% end_if %>" <% if Embedded %>data-type="iframe"<% end_if %>>
                <% if hasIcone %>
                <% if $Icone %><span class="uk-margin-small-right" data-uk-icon="icon:  $Icone;"></span><% end_if %> 
	            <span class="dk-link-with-icon-text">$Title</span>
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