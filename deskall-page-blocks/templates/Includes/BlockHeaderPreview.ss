 <div class="block-header-preview">
    <div class="elemental-preview__icon">$Icon</div>
    <div class="elemental-preview__detail">
        <h3><% if Title %>$Title <% end_if %><small>$Type</small></h3>
    </div>
    <% if Locales %>
    <% loop Locales %>
        <span>$Title</span>
    <% end_loop %>
    <% end_if %>
</div>