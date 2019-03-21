<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
  $HTML
</div>


<div class="menu-container uk-box-shadow-large uk-position-relative">
 <div class="uk-padding">
    <div class="uk-position-top-left uk-position-small">
      <a href="$Menu.File.URL" target="_blank" class="uk-button uk-button-primary"><i class="fa fa-print uk-margin-small-right"></i>Menu drucken (PDF)</a>
    </div>
    

    <div class="uk-child-width-1-1" data-uk-grid>
      <% loop Menu.ActiveElements.sort('Sort') %>
        <% include CarteElement %>
     <% end_loop %>
   </div>
  </div>
</div>


<% if LinkableLinkID > 0 %>
<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>