<div class="uk-card uk-padding-remove">
				           <% if MainImage.exists %> <div class="uk-card-media-top">
				                <a href="$Link" title="<%t Product.SEEPAGE 'Produkt ansehen' %>"><img src="$MainImage.Fit(250,250).URL" alt="$Title" /></a>
				            </div>
				            <% end_if %>
				            <div class="uk-card-body uk-padding-remove">
				                <div class="uk-card-title uk-text-truncate uk-margin" data-uk-tooltip="<%t Product.SEEPAGE 'Produkt ansehen' %>"><a href="$Link" title="<%t Product.SEEPAGE 'Produkt ansehen' %>">$Title</a></div>
				                <% if Online %>
				                <p><i class="fa fa-check uk-margin-small-right"></i>online verfügbar</p>
				                <% else_if DeliveryTime %><p><i class="fa fa-truck uk-margin-small-right"></i><%t Product.DeliveryTime 'Lieferzeit:' %> $DeliveryTime</p>
				                <% end_if %>
				                <div><% if $currentPrice != $Price %><s>$Price EUR</s><strong class="uk-margin-left">$DiscountPrice EUR</strong><% else %><strong>$Price EUR</strong><% end_if %></div>
				                $LeadText.LimitWordCount(50)
				                <div class="uk-margin-small">
				                	<a class="uk-button uk-button-primary" href="$BuyLink" title="<%t Product.BUYNOW 'Jetzt kaufen' %>"><i class="fa fa-shopping-cart uk-margin-right"></i><%t Product.BUYNOW 'Jetzt kaufen' %></a>
				                </div>
				            </div>
				        </div>