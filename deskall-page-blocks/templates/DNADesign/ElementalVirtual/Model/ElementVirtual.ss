<% if $LinkedElement.ClassName == "LargeImageBlock" || $LinkedElement.ClassName == "SliderBlock" %>
<% include Layout/DefaultHolder Element=$LinkedElement %>
<% else %>
<% include Layout/BlockHolder Element=$LinkedElement %>
<% end_if %>