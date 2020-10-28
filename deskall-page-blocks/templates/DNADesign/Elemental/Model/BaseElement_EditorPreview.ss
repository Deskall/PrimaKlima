<div class="elemental-preview">
    <a <% if $CMSEditLink %>href="$CMSEditLink"<% end_if %> class="elemental-edit">
        <div class="elemental-preview__icon">$Icon</div>

        <div class="elemental-preview__detail">
            <h3><% if Title %>$Title <% end_if %><small>$Type <% if not isVisible %>Deaktiviert<% end_if %></small></h3>

            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
        </div>
    </a>
</div>
