<div>
            <div class="uk-clearfix"><div class="uk-float-left"><strong>$Title</strong><strong class="uk-margin-left">$PrintPrice</strong></div></div>
            <% loop $Dishes %>
            <div>
                $Title
            </div>
            <% if not Last %>
            ***
            <% end_if %>
            <% end_loop %>
        </div>