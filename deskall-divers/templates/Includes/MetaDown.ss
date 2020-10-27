 <% if BodyScripts %>
 <% loop BodyScripts %>
 $Script
 <% end_loop %>
 <% end_if %>
 <% if isLive %>
 <script src="$ThemeDir/javascript/main.min.js?v=$LastChangeJS"></script>
 $BodyCss
 <% else %>
 <link rel="stylesheet" type="text/css" href="$ThemeDir/css/body.min.css" />
 <% end_if %>
