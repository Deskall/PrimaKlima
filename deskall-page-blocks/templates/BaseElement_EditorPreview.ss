<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <% include BlockHeaderPreview %>
        <div class="elemental-preview__detail">
            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
        </div>
    </a>
</div>
