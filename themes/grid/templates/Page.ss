<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName">
    <div class="uk-offcanvas-content">
      <% include Header %>
      <div class="main-content-wrapper">
      $Layout
      </div>
      <% include Footer %>

      <% include NavMobile %>
    </div>

    <% if BodyScripts %>
      <% loop BodyScripts %>
      $Script
      <% end_loop %>
    <% end_if %>
    $SiteConfig.GoogleAnalyticsCode
  </body>
</html>
