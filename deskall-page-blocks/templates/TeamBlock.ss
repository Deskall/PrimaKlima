<div class="uk-child-width-auto uk-grid-small uk-grid-match" data-uk-grid data-uk-height-match=".team-image">
    <% if activeBoxes.exists %>
        <% loop activeBoxes %>
        <div>
            <div class="team-box uk-transition-toggle">
                <div class="uk-inline-clip" tabindex="0">
                    <div class="team-image">
                        <% if Image %>
                        <img src="<% if $Image.getExtension == "svg" %>$Image.URL<% else %>$Image.ScaleWidth(350).CropHeight(250).URL<% end_if %>" width="350" height="250" alt="$Title">
                        <% else %>
                        <img src="themes/standard/img/logo.svg" width="350" height="250" alt="$Title">
                        <% end_if %>
                    </div>
                    <div class="team-title">
                        <div><strong class="title">$Title</strong></div>
                        <div class="function">$Function</div>
                        <div class="uk-transition-fade uk-transition-slide-bottom">
                            <% if Email %>
                            <div><a href="mailto:$Email">$Email</a></div>
                            <% end_if %>
                            <% if Telephone %>
                            <div><a href="tel:$Telephone">$Telephone</a></div>
                            <% end_if %>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <% end_loop %>
    <% end_if %>
</div>