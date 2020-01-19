<div id="offcanvas-flip" data-uk-offcanvas="mode: reveal; overlay: true">
    <div class="uk-offcanvas-bar uk-width-1-1 dk-nav-mobile-container">

      <button class="uk-offcanvas-close" type="button" data-uk-close></button>
      <form method="GET" action="$OfferPage.Link" class="finder-bar uk-grid-small uk-flex uk-flex-right uk-flex-middle" data-uk-grid>

         <div class="uk-width-1-3 uk-flex uk-flex-left uk-flex-middle">
              <strong class="uk-margin-small-right"><%t FinderBar.PositionLabel 'Was?' %></strong>
              <input list="positions" name="position" class="uk-input" placeholder="<%t FinderBar.Position 'Beruf,Position' %>">
              <datalist id="positions">
                   <% loop $Portal.getPositions %>
                   <option value="$Title">$Title</option>
                   <% end_loop %>
             </datalist>
       </div>



       <div class="uk-width-1-3 uk-flex uk-flex-left uk-flex-middle">
        <strong class="uk-margin-small-right"><%t FinderBar.PlaceLabel 'Wo?' %></strong>
        <input list="places" name="ort" class="uk-input" placeholder="<%t FinderBar.Place 'Ort' %>">
        <datalist id="places">
             <% loop $Portal.getCities.groupedBy(City) %>
             <option value="$City" <% if $Selected %>selected<% end_if %>>$City</option>
             <% end_loop %>
       </datalist>
 </div>
 <div class="uk-width-1-3">
  <button class="uk-button button-PrimaryBackground uk-flex uk-flex-middle"><span><%t FinderBar.SearchAction 'Jobs suchen' %></span><i class="icon icon-chevron-right uk-margin-small-left uk-text-small"></i></button>
</div>
</form>
<div class="uk-margin-top">
      <% loop SiteConfig.activeMobileMenuBlocks %>
      <% if Type == 'form' %>
      <div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
      <% else_if Type == "Languages" %>
      <% include MenuBlock_Languages Locales=Top.Locales %>
      <% else %>
      $forTemplate
      <% end_if %>
      <% end_loop %>
</div>
</div>
</div>