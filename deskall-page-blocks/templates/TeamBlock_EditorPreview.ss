<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <div class="block-header-preview">
            <div class="elemental-preview__icon">$Icon</div>
            <div class="elemental-preview__detail">
                <h3><% if Title %>$Title <% end_if %><small>$Type</small></h3>
            </div>
        </div>

        <div class="elemental-preview__detail">
            <% if Boxes.exists %>
            <table>
                <tr>
                    <% loop Boxes.limit(3) %>
                    <td><img src=$Image.Thumbnail(80,80).URL width="80" height="80" /></td>
                    <% end_loop %>
                    <td>...</td>
                </tr>
            </table>
            <% end_if %>
        </div>
    </a>
</div>
