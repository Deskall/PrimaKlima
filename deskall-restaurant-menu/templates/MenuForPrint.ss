<div>
 <strong style="text-align:left;">$Title</strong><strong style="text-align:right;margin-left:10px">$PrintPrice</strong>
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