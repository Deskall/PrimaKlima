<div>
   <div><table><tr><td><strong>$Title</strong></td><td><strong style="padding-left:10px">$PrintPrice</strong></td></tr></table></div>
 <% loop $Dishes %>
 <div style="text-align:center;">
    $Title
</div>
<% if not Last %>
<div style="text-align:center;">
    ***
</div>
<% end_if %>
<% end_loop %>
</div>