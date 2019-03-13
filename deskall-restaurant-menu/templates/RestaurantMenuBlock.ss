<div class="dk-text-content $TextAlign  $TextColumns <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	 $HTML
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>

<div class="menu-container">
    <div class="uk-padding-large">
        <% with Menu %>
        <h4>$Title $Date.Nice</h4>
        <div class="uk-child-width-1-2@s" data-uk-grid>
           <% loop Elements.filter('Type','menu') %>
           <% with Menu %>
           <div>
            <div class="uk-clearfix"><div class="uk-float-left"><strong>$Title</strong></div><div class="uk-float-right"><strong>$PrintPrice</strong></div></div>
            <% loop $Dishes %>
            <div>
                $Title
            </div>
            ***
            <% end_loop %>
           </div>
           <% end_with %>
           <% end_loop %>
        </div>
        <% end_with %>
    </div>
</div>