

                <% if Description %>
                <strong>$Title:</strong>
                <table>
                	<tr><td>$PrintDescription</td><% if Price > 0 %><td>$PrintPrice</td><% end_if %></tr>
                </table>
                <% else %>
                <table>
                	<tr><td>$Title</td><% if Price > 0 %><td>$PrintPrice</td><% end_if %></tr>
                </table>
                <% end_if %>
          
            <% if Subdishes.exists %>
            <% loop Subdishes %>
            	<% if Description %>
                <strong>$Title:</strong>
                <table>
                	<tr><td>$PrintDescription</td><% if Price > 0 %><td>$PrintPrice</td><% end_if %></tr>
                </table>
                <% else %>
                <table>
                	<tr><td>$Title</td><% if Price > 0 %><td>$PrintPrice</td><% end_if %></tr>
                </table>
                <% end_if %>
            <% end_loop %>
            <% end_if %> 
         