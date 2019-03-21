

                <% if Description %>
                <strong>$Title:</strong>
                <table>
                	<tr><td <% if Price > 0 %>width="250"<% end_if %>>$PrintDescription</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% else %>
                <table>
                	<tr><td <% if Price > 0 %>width="250"<% end_if %>>$Title</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% end_if %>
          
            <% if Subdishes.exists %>
            <% loop Subdishes %>
            	<% if Description %>
                <strong style="padding-left:10px">$Title:</strong>
                <table style="padding-left:10px">
                	<tr><td <% if Price > 0 %>width="250"<% end_if %>>$PrintDescription</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% else %>
                <table>
                	<tr><td <% if Price > 0 %>width="250"<% end_if %>>$Title</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% end_if %>
            <% end_loop %>
            <% end_if %> 
         