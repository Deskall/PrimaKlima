<div class="html-dropdown chosen-container chosen-container-single chosen-container-single-nosearch" data-empty-string="$EmptyString">
    <a class="chosen-single" tabindex="0"></a>  
  <div class="chosen-drop"  tabindex="-1">
   <% loop $Options %>
    <div data-value="$Value" class="html-dropdown-option <% if $Selected %>selected<% end_if %> <% if $Disabled %>disabled<% end_if %>">
     $HTML
    </div>
  <% end_loop %>
  </div>
  <select $AttributesHTML>
  <% loop $Options %>
    <% if Value != "" %>
  	<option value="$Value.XML"
  		<% if $Selected %> selected="selected"<% end_if %>
  		<% if $Disabled %> disabled="disabled"<% end_if %>
  		><% if $Title.exists %>$Title.XML<% else %>&nbsp;<% end_if %>
  	</option>
    <% end_if %>
  <% end_loop %>
  </select>
</div>


