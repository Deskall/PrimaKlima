<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName $ExtraHeaderClass">
    $SiteConfig.BodyScripts
    <div class="uk-offcanvas-content">
      <% include Header %>
      <main class="main-content-wrapper">
          $Layout
      </main>
      <% include Footer %>
      <% include Modals %>
    </div>
    <% if BodyScripts %>
      <% loop BodyScripts %>
      $Script
      <% end_loop %>
    <% end_if %>
    $SiteConfig.GoogleAnalyticsCode
    $BodyCss
  </body>
</html>