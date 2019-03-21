<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
  $HTML
</div>


<div class="menu-container uk-box-shadow-large uk-position-relative">
    <div class="uk-position-top-left">
      <a href="$File.URL" target="_blank"><i class="fa fa-print uk-margin-small-right"></i>Menu drucken (PDF)</a>
    </div>
    <%-- <div class="uk-padding-large">
        <% with Menu %>
        <h4>$Title $Date.Nice</h4>
        <div class="uk-child-width-1-2@s" data-uk-grid>
         <% loop Elements.filter('Type','menu') %>
         <% with Menu %>
         <div>
            <div class="uk-clearfix"><div class="uk-float-left"><strong>$Title</strong><strong class="uk-margin-left">$PrintPrice</strong></div></div>
            <% loop $Dishes %>
            <div>
                $Title
            </div>
            <% if not Last %>
            ***
            <% end_if %>
            <% end_loop %>
        </div>
        
        <% end_with %>
        <% end_loop %>
    </div> --%>

    <div class="uk-child-width-1-1" data-uk-grid>
      <% loop Elements.sort('Sort') %>
        <% include CarteElement %>
     <% end_loop %>
 </div>
 <% end_with %>
</div>
</div>


<% if LinkableLinkID > 0 %>
<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>