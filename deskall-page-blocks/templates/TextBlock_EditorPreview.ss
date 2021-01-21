<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <div class="block-header-preview">
            <div class="elemental-preview__icon">$Icon</div>
            <div class="elemental-preview__detail">
                <h3><% if Title %>$Title <% end_if %><small>$Type</small> la</h3>
            </div>
        </div>

        <div class="elemental-preview__detail">
            <% if $ContentImage %>
            	<% if ContentImage.getExtension == "svg" %><img src="$ContentImage.URL" width="100" height="100" /><% else %> $ContentImage.Fit(100,100)<% end_if %>
            <% end_if %>
            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
        </div>
    </a>
</div>
