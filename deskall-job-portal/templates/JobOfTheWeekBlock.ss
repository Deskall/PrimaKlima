


<div data-uk-slider="center: true">

    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

        <ul class="uk-slider-items uk-child-width-1-2@s uk-grid uk-grid-match">
            <% loop Jobs %>
            <li>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-media-top uk-flex uk-flex-middle">
                        <img <% if $Customer.Logo.getExtension == "svg" %>src="$Customer.Logo.URL"<% else %>src="$Customer.Logo.Fit(250,150).URL"<% end_if %> alt="Logo von $Company" width="250" height="150">
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title">$Title</h3>
                        <a class="uk-button button-PrimaryBackground" href="$previewLink">Zum Inserat</a>
                    </div>
                </div>
            </li>
            <% end_loop %>
        </ul>

        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

    </div>

    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

</div>


