<div class="elemental-preview">
    <a href="$CMSEditLink" class="elemental-edit">
       <% include BlockHeaderPreview %>
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
