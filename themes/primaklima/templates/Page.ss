<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$Title</title>
    <link rel="stylesheet" href="/themes/primaklima/css/main.css">
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
    <% require javascript("/themes/primaklima/javascript/app.js") %>
  </body>
</html>
