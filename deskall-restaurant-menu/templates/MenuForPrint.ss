<div>
    <div><table><tr><td><strong>$Title</strong></td><td><strong style="padding-left:10px">$PrintPrice</strong></td></tr></table></div>
    <div style="text-align:center;">
    <% loop $Dishes %>
    $Title<br/>
    <% if not Last %>
        ***<br/>
    <% end_if %>
    <% end_loop %>
    </div>
</div>