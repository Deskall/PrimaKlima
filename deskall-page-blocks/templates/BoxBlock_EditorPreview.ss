
<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <div class="block-header-preview">
            <div class="elemental-preview__icon">$Icon</div>
            <div class="elemental-preview__detail">
                <h3><% if Title %>$Title <% end_if %><small>$Type</small></h3>
            </div>
        </div>

        <div class="elemental-preview__detail">
            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
            <% if $ActiveBoxes %>
            <table>
                <tr>
                <% loop $ActiveBoxes.limit(3) %>
                <td>
                    <% if Image.getExtension == "svg" %><img src="$Image.URL" width="100" height="100" /><% else %>$Image.FocusFill(100,100)<% end_if %><br/>
                    $Title
                </td>
                <% end_loop %>
                <% if $ActiveBoxes.count > 2 %>
                <td>...</td>
                <% end_if %>
                </tr>
            </table>
            <% end_if %>
        </div>
    </a>
</div>
