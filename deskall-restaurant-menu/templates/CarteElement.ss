$Type
<% if Type == "menu" %>
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
<% else_if Type == "group" %>
ici
  <% if Children %>
  <div class="uk-child-width-1-1 uk-child-width-1-2@s <% if Children.count > 2 %>uk-child-width-1-{$Children.count}@l" data-uk-grid>
    <% loop Children %>
    <div><% include CarteElement %></div>
    <% end_loop %>
  </div>
  <% end_if %>
<% else_if Type == "element" %>
    <div>
      <% if Content %>
      $Content
      <% end_if %>
    </div>
<% end_if %>