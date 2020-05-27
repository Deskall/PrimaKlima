
<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
        <% include BlockHeaderPreview %>

        <div class="elemental-preview__detail">
           
            <% if Image.getExtension == "svg" %><img src="$Image.URL" class="svg-banner-thumbnail" width="300" height="200" /><% else %>$Image.Fit(300,200)<% end_if %>
            
            <% if $Summary %>
                <p>$Summary.RAW</p>
            <% end_if %>
        </div>
    </a>
</div>
