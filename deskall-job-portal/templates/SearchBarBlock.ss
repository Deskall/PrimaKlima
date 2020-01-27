<form method="GET" action="$getPage.OfferPage.Link" class="finder-bar uk-grid-small uk-flex uk-flex-center uk-flex-middle $TextAlign" data-uk-grid>

         <div class="uk-width-1-3@s">
              <strong class="uk-margin-small-right"><%t FinderBar.PositionLabel 'Was?' %></strong>
              <input list="positions" name="position" class="uk-input" placeholder="<%t FinderBar.Position 'Beruf,Position' %>">
              <datalist id="positions">
                   <% loop $getPositions %>
                   <option value="$Title">$Title</option>
                   <% end_loop %>
             </datalist>
       </div>



       <div class="uk-width-1-3@s">
        <strong class="uk-margin-small-right"><%t FinderBar.PlaceLabel 'Wo?' %></strong>
        <input list="places" name="ort" class="uk-input" placeholder="<%t FinderBar.Place 'Ort' %>">
        <datalist id="places">
             <% loop $getCities.groupedBy(City) %>
             <option value="$City" <% if $Selected %>selected<% end_if %>>$City</option>
             <% end_loop %>
       </datalist>
 </div>
 <div class="uk-width-1-3@s">
  <button class="uk-button button-PrimaryBackground uk-flex uk-flex-middle"><span><%t FinderBar.SearchAction 'Jobs suchen' %></span><i class="icon icon-chevron-right uk-margin-small-left uk-text-small"></i></button>
</div>
</form>