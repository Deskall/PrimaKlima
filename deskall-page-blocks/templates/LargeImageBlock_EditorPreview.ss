
<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <div class="block-header-preview">
            <div class="elemental-preview__icon">$Icon</div>
            <div class="elemental-preview__detail">
                <h3><% if Title %>$Title <% end_if %><small>$Type</small></h3>
            </div>
        </div>

        <div class="elemental-preview__detail">
           
            $File.Fit(300,200)
            
            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
        </div>
    </a>
</div>
