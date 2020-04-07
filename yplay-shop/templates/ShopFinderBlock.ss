<% if HTML %>
   <div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
      <% if CollapseText %>
                  <div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
                  <div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
                  <% else %>
                  $HTML
                  <% end_if %>
   </div>
<% end_if %> 
   <% if LinkableLinkID > 0 %>
      <% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
   <% end_if %>

   <div class="shop-map-container clearfix">
      <div class="map-block">
         <div class="map" id="googlemap_shop-finder" data-objects='{$JsonShops.ATT}'>
         </div>
      </div>
   </div>

   <div class="suche-formular-container clearfix uk-margin-top">
      <div class="uk-grid-small" data-uk-grid>
         <div class="uk-width-1-3 uk-width-1-4@m uk-position-relative"><input type="text" name="plz-search" class="uk-input uk-width-medium" placeholder="PLZ" /><div id="reset-search" class="uk-position-center-right uk-position-small" hidden><a data-close><i class="icon icon-close"></i></a></div></div>
         <div class="uk-width-2-3 uk-width-3-4@m"><button class="uk-button uk-button-primary" data-search>Suchen <i class="icon icon-chevron-right uk-light"></i></button></div>
      </div>
   </div>

   <div class="shop-list link-block clearfix uk-margin-top">
      <% loop Shops %>
      <div id="shop-{$ID}" class="link-item clearfix">
         <strong>$Title</strong><br/>
         <p>$AdresseTitle<br/>
            $Adresse<br/>
            $PLZ $City
         </p>
         <p>
            <a id="show-marker-{$ID}" href="#googlemap_shop-finder" data-uk-scroll="offset:100">Auf Karte zeigen</a>
         </p>
         <% if Offnungszeiten %>
         <div class="hours-{$ID}">
         <p><a data-uk-toggle="target: .hours-{$ID}">Öffnungszeiten<i class="icon icon-chevron-down uk-margin-small-left"></i></a></p>
         </div>
         <div class="hours-{$ID}" hidden>
            <p><a data-uk-toggle="target: .hours-{$ID}">Öffnungszeiten<i class="icon icon-chevron-up uk-margin-small-left"></i></a></p>
            $Offnungszeiten
         </div>
         <% end_if %>
      </div>
      <% end_loop %>
   </div>
   <div id="no-near-shops" hidden><p>Es gibt keinen Laden in der Umgebung</p></div>

