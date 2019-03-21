<table>
    <tr>
        <% loop Children %>
            <td>
                <% if Type == "menu" %>
                <% with $Menu %>
                <% include MenuForPrint %>
                <% end_with %>
                <% else_if Type == "dish" %>
                <% with $Dish %>
                <% include DishForPrint %>
                <% end_with %>
                <% end_if %>
            </td>
        <% end_loop %>
    </tr>
</table>
