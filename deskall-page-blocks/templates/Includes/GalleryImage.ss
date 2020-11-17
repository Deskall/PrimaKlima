<figure>
	<img src="<% if $getExtension == "svg" %>$URL<% else %><% if PaddedImages %>$FitMax($Width,$Height).URL<% else %>$FocusFill($Width,$Height).URL<% end_if %><% end_if %>" alt="$Alt"  class="uk-width-1-1 $Padding" data-uk-img>
	<% if Description %><figcaption>$Description</figcaption><% end_if %>
</figure>