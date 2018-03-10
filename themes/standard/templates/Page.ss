<!doctype html>
<html lang="$ContentLocale" dir="ltr" class="uk-text-break">
  <head>
     <% include Meta %>
  </head>
  <body>
    <div class="uk-offcanvas-content">
      <% include Header %>
      $Layout
      <% include Footer %>

      <% include NavMobile %>
    </div>

    <% if isLive %>
    <script async defer src="$ThemeDir/javascript/main.min.js"></script>
    <% else %>
    <script src="$ThemeDir/javascript/main.js"></script>
    <% end_if %>

    <% if headScripts %>
      <% loop headScripts %>
      <script>$Script</script>
      <% end_loop %>
    <% end_if %>
  </body>
</html>
