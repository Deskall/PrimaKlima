<% if Type == "group" %>
<div class="$Margin">
  <% if Children %>
  <div class="uk-child-width-1-1 uk-child-width-1-2@s <% if Children.count > 2 %>uk-child-width-1-{$Children.count}@l<% end_if %>" data-uk-grid>
    <% loop Children %>
    <div><% include CarteElement %></div>
    <% end_loop %>
  </div>
  <% end_if %>
</div>
<% end_if %>
<% if Type == "dish" %>
 <% with Dish %>
    <div class="$Top.Margin">
      <% if Description %>
      <strong class="uk-clearfix">$Title:</strong>
      <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
        <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$PrintDescription</div>
        <% if PriceDescription %><div>$PriceDescription</div><% end_if %>
        <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
      </div>
      <% else %>
      <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
        <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
        <% if PriceDescription %><div>$PriceDescription</div><% end_if %>
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
          <% if PriceDescription %><div>$PriceDescription</div><% end_if %>
          <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
        </div>
        <% else %>
        <div class="uk-grid-small uk-flex uk-flex-bottom" data-uk-grid>
         <div class="uk-width-expand" <% if Price > 0 %>data-uk-leader<% end_if %>>$Title</div>
         <% if PriceDescription %><div>$PriceDescription</div><% end_if %>
         <% if Price > 0 %><div>$PrintPrice</div><% end_if %>
       </div>
       <% end_if %>
      </div>
      <% end_loop %>
    <% end_if %> 
  <% end_with %>
<% end_if %>
<% if Type == "element" %>
    <div class="$Margin">
      <% if Content %>
      $Content
      <% end_if %>
    </div>
<% end_if %>



<% if Type == "menu" %>
  
  <div class="$Margin uk-text-center">
    <div><strong>$Menu.Title</strong><strong class="uk-margin-left">$Menu.PrintPrice</strong></div>
    <% loop $Menu.Dishes %>
    <div>
      $Title
    </div>
      <% if not Last %>
      ***
      <% end_if %>
    <% end_loop %>
  </div>
<% end_if %>

<% if Type == "divider" %>
<div class="$Margin">
<hr>
</div>
<% end_if %>