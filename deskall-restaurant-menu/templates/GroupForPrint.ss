<table>
    <tr>
        <% loop Children %>
            <td>
                <% if ClassName == "Menu" %>
                <% include MenuForPrint %>
                <% else_if ClassName == "Dish" %>
                <% include DishForPrint %>
                <% end_if %>
            </td>
        <% end_loop %>
    </tr>
</table>
