 <% if BodyScripts %>
 <% loop BodyScripts %>
 $Script
 <% end_loop %>
 <% end_if %>
 <% if isLive %>
 $BodyCss
 <% else %>
 <link rel="stylesheet" type="text/css" href="$ThemeDir/css/body.min.css" />
 <% end_if %>
