<% if $LinkedElement.ClassName == "LargeImageBlock" || $LinkedElement.ClassName == "SliderBlock" || $LinkedElement.ClassName == "FormBlock" %>
<% include Layout/ElementHolder Element=$LinkedElement %>
<% else %>
<% include Layout/BlockHolder Element=$LinkedElement %>
<% end_if %>