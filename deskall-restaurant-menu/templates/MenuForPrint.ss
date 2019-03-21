<div>
    <div style="text-align:center;"><strong style="text-align:left;">$Title</strong><strong style="padding-left:10px">$PrintPrice</strong></div>
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