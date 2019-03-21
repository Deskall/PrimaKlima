

                <% if Description %>
                <strong>$Title:</strong>
                <table>
                	<tr><td width="250">$PrintDescription</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% else %>
                <table>
                	<tr><td width="250">$Title</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% end_if %>
          
            <% if Subdishes.exists %>
            <% loop Subdishes %>
            	<% if Description %>
                <strong>$Title:</strong>
                <table>
                	<tr><td width="250">$PrintDescription</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% else %>
                <table>
                	<tr><td width="250">$Title</td><% if Price > 0 %><td style="text-align:right" width="60">$PrintPrice</td><% end_if %></tr>
                </table>
                <% end_if %>
            <% end_loop %>
            <% end_if %> 
         