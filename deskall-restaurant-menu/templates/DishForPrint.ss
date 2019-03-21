<div>

                <% if Description %>
                <strong class="uk-clearfix">$Title:</strong>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                </div>
                <% else %>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                </div>
                <% end_if %>
            </div>
            <% if Subdishes.exists %>
            <% loop Subdishes %>
            <div class="<% if First %>uk-margin-remove-top<% end_if %> uk-margin-remove">
                <% if Description %>
                <strong class="uk-clearfix">$Title:</strong>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                </div>
                <% else %>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                 <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
                 <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
             </div>
             <% end_if %>
         </div>
         <% end_loop %>
         <% end_if %>