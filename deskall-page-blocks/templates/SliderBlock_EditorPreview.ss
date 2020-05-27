
<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <% include BlockHeaderPreview %>

        <div class="elemental-preview__detail">
            <% if $ActiveSlides %>
            <div class="slide-container">
                <% loop ActiveSlides.limit(2) %>
                    <% if $Image.getExtension == "svg" %><img src="$Image.URL" alt="$Image.AtlTag($Title)" title="$Image.TitleTag($Title)" width="200" height="100" class="svg-slider-thumbnail" /><% else %>$Image.FocusFill(200,100)<% end_if %>
                <% end_loop %>
                <% if $ActiveSlides.count > 2 %>
                ...
                <% end_if %>
            <% end_if %>
            </div>
            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
        </div>
    </a>
</div>
