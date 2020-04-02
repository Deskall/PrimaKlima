<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName $Level(1).ExtraCSSClass">
    $SiteConfig.BodyScripts
    <div class="uk-offcanvas-content">
      <% include Header %>
      <% if activeCart %>
      <% with activeCart %>
      <% include ShopCart %>
      <% end_with %>
      <% end_if %>
      <main class="main-content-wrapper">
          $Layout
      </main>

      <% include Footer %>
    </div>
   <% include MetaDown %>
   <% include NavMobile %>
  </body>
</html>