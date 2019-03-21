<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
  $HTML
</div>


<div class="menu-container uk-box-shadow-large">
    <div class="uk-padding-large">
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
    </div>

    <div class="uk-child-width-1-1" data-uk-grid>
        <% loop Elements.exclude('Type','menu').sort('Sort') %>
        <% if Type == "dish" %>
            <% with Dish %>
            <div>

                <% if Description %>
                <strong class="uk-clearfix">$Title:</strong>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                </div>
                <% else %>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                </div>
                <% end_if %>
            </div>
            <% if Subdishes.exists %>
            <% loop Subdishes %>
            <div class="<% if First %>uk-margin-remove-top<% end_if %> uk-margin-remove">
                <% if Description %>
                <strong class="uk-clearfix">$Title:</strong>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                    <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
                    <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
                </div>
                <% else %>
                <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
                 <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
                 <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
             </div>
             <% end_if %>
         </div>
         <% end_loop %>
         <% end_if %>
         <% end_with %>
      <% else %>
        <div>
          <% if Title %><strong class="uk-clearfix">$Title</strong><% end_if %>
          <% if Content %>
          $Content
          <% end_if %>
        </div>
      <% end_if %>
     <% end_loop %>
 </div>
 <% end_with %>
</div>
</div>


<% if LinkableLinkID > 0 %>
<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>