
<div id="shop-{$ID}" class="link-item clearfix">
   <strong>$Title</strong><br/>
   <p>$AdresseTitle<br/>
      $Adresse<br/>
      $PLZ $City
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