<!doctype html>
<html lang="$ContentLocale" dir="ltr" class="uk-text-break">
  <head>
     <% include Meta %>
      <script src="https://www.google.com/recaptcha/api.js?sitekey=6LchV0kUAAAAAO933jAsFfyjanFlxT2nbRd1s5Tc" async defer></script>
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

  </body>
</html>
