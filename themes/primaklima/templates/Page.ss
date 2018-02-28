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
    <script src="$ThemeDir/javascript/main.min.js"></script>
    <% else %>
    <% require javascript("/themes/primaklima/javascript/main.js") %>
    <% end_if %>

  </body>
</html>
