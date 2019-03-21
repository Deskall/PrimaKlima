
<%-- <% if Type == "dish" %>
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
<% else_if $Type == "menu" %>
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
<% else_if $Type == "group" %>

  <% if Children %>
  <div class="uk-child-width-1-1 uk-child-width-1-2@s <% if Children.count > 2 %>uk-child-width-1-{$Children.count}@l" data-uk-grid>
    <% loop Children %>
    <div><% include CarteElement %></div>
    <% end_loop %>
  </div>
  <% end_if %>
<% else_if $Type == "element" %>
    <div>
      <% if Content %>
      $Content
      <% end_if %>
    </div>
<% end_if %> --%>
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
<% end_if %>
<% if Type == "element" %>
    <div>
      <% if Content %>
      $Content
      <% end_if %>
    </div>
<% end_if %>

<% if Type == "group" %>
  <% if Children %>
  <div class="uk-child-width-1-1 uk-child-width-1-2@s <% if Children.count > 2 %>uk-child-width-1-{$Children.count}@l" data-uk-grid>
    <% loop Children %>
    <div><% include CarteElement %></div>
    <% end_loop %>
  </div>
  <% end_if %>
<% end_if %>

<% if Type == "menu" %>
  
  <div>
    <div class="uk-clearfix"><div class="uk-float-left"><strong>$Title</strong><strong class="uk-margin-left">$PrintPrice</strong></div></div>
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