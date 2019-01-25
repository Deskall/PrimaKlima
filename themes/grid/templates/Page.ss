<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName">
    <div class="uk-offcanvas-content">
      <div data-uk-grid class="uk-grid-collapse">
        <div class="uk-width-1-3@s">
          <% include Header %>
        </div>
        <div class="uk-width-2-3">
          <div class="main-content-wrapper">
          $Layout
          </div>
        </div>
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
