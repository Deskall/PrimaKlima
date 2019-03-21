<div>
            <div class="uk-clearfix"><div class="uk-float-left"><strong>$Title</strong><strong class="uk-margin-left">$PrintPrice</strong></div></div>
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