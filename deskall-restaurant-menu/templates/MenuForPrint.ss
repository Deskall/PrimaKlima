<div style="text-align:center;">
           <strong style="text-align:left;">$Title</strong><strong style="text-align:right;margin-left:10px">$PrintPrice</strong></div></div>
            <% loop $Dishes %>
            <div >
                $Title
            </div>
            <% if not Last %>
            <div>
            ***
            </div>
            <% end_if %>
            <% end_loop %>
        </div>