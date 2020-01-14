


<div data-uk-slider="autoplay:true;autoplay-interval:5000;finite:false;">

    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

        <ul class="uk-slider-items uk-child-width-1-2@s uk-grid uk-grid-match">
            <% loop Jobs %>
            <li>
                <div class="uk-card uk-card-default">
                    <div class="uk-card-media-top uk-padding-small">
                        <img <% if $Customer.Logo.getExtension == "svg" %>src="$Customer.Logo.URL"<% else %>src="$Customer.Logo.Fit(250,150).URL"<% end_if %> alt="Logo von $Company" width="250" height="150">
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-text-truncate">$Title</h3>
                        <div><i>$Customer.Company</i></div>
                        <div class="uk-flex uk-flex-center uk-grid uk-text-small uk-margin-small-top">
                        	<div class="place"><i class="icon icon-location uk-margin-small-right"></i>$City</div>
                        	<% with Parameters.filter('Title','Anstellung').first %><div class="type"><i class="icon icon-information uk-margin-small-right"></i>$Value</div><% end_with %>
                        	<div class="start"><i class="icon icon-calendar uk-margin-small-right"></i>$PublishedDate.Nice</div>
                        </div>
                        <div class="uk-margin-top">
                        	<a class="uk-button button-PrimaryBackground" href="$previewLink">Zum Inserat</a>
                        </div>
                    </div>
                </div>
            </li>
            <% end_loop %>
        </ul>

    </div>

    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

</div>


