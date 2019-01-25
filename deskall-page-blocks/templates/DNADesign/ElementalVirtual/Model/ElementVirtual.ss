<% if $LinkedElement.ClassName == "LargeImageBlock" || $LinkedElement.ClassName == "SliderBlock" %>
<% include Layout/ElementHolder Element=$LinkedElement %>
<% else %>
<% include Layout/BlockHolder Element=$LinkedElement %>
<% end_if %>