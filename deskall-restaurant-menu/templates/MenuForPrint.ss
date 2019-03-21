<div>
    <div><table><tr><td style="text-align:center;"><strong>$Title</strong></td><td style="text-align:center;"><strong>$PrintPrice</strong></td></tr></table></div>
    <div style="text-align:center;">
    <% loop $Dishes %>
    $Title<br/>
    <% if not Last %>
        ***<br/>
    <% end_if %>
    <% end_loop %>
    </div>
</div>