 <% loop $Children %>
    <a href="$Link" class="lvl-$CurrentLevel">$MenuTitle.XML</a>
    <% if $Children %>
    	<% include SubMenuMobile %>
    <% end_if %>
 <% end_loop %>