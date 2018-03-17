
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
            <% if $OrderedImages %>
            <table>
                <tr>
                <% loop $OrderedImages.limit(3) %>
                <td>
                    <% if File.getExtension == "svg" %><img src="$URL" class="svg-gallery-thumbnail" width="60" height="60" /><% else %>$FitMax(60,60)<% end_if %>
                </td>
                <% end_loop %>
                <td>...</td>
                </tr>
            </table>
            <% end_if %>
        </div>
    </a>
</div>
