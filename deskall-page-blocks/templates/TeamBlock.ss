<div class="uk-child-width-auto uk-grid-small uk-grid-match" data-uk-grid data-uk-height-match=".team-image">
    <% if activeBoxes.exists %>
        <% loop activeBoxes %>
        <div>
            <div class="team-box uk-transition-toggle">
                <div class="uk-inline-clip uk-light" tabindex="0">
                    <div class="team-image">
                        <% if Image %>
                        <img src="$Image.ScaleWidth(350).CropHeight(250).URL" alt="$Title">
                        <% else %>
                        <img src="logo.svg" width="350" height="250" alt="$Title">
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
                    <%-- <div class="uk-position-bottom-center uk-padding-small uk-transition-fade uk-height-1-1 info-container uk-width-1-1 uk-flex uk-flex-left uk-flex-middle">
                        <div class="uk-transition-slide-top-small">
                            <div><strong class="uk-margin-remove uk-text-primary">$Title</strong></div>
                            <div>$Function</div>
                        </div>
                        <div class="uk-transition-slide-bottom-small">
                            <div><a href="mailto:$Email">$Email</a></div>
                            <div><a href="tel:$Telephone">$Telephone</a></div>
                        </div>
                    </div> --%>
                </div>
            </div>
        </div>
        <% end_loop %>
    <% end_if %>
</div>