hellooooo
<% if $LinkedElement.ClassName == "LargeImageBlock" || $LinkedElement.ClassName == "SliderBlock" || $LinkedElement.ClassName == "DNADesign\ElementalUserForms\Model\ElementForm" %>
<% include Layout/ElementHolder Element=$LinkedElement %>
<% else %>
<% include Layout/BlockHolder Element=$LinkedElement %>
<% end_if %>