
<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <div class="block-header-preview">
            <div class="elemental-preview__icon">$Icon</div>
            <div class="elemental-preview__detail">
                <h3><% if Title %>$Title <% end_if %><small>$Type</small></h3>
            </div>
        </div>

        <div class="elemental-preview__detail">
            <% if $ActiveSlides %>
            <div class="slide-container">
                <% loop ActiveSlides.limit(2) %>
                    $Image.FocusFill(200,100)
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
