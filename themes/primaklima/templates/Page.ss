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

    <% require javascript("/themes/primaklima/javascript/vendor/jquery.js") %>
    <% require javascript("/themes/primaklima/javascript/vendor/uikit.min.js") %>
    <% require javascript("/themes/primaklima/javascript/vendor/uikit-icons.min.js") %>
    <% require javascript("/themes/primaklima/javascript/vendor/flatpicker.min.js") %>
    <% require javascript("/themes/primaklima/javascript/app.js") %>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </body>
</html>
