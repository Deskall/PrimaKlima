<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName <% if ExtraCSSClass %>$ExtraCSSClass<% else %>$Level(1).ExtraCSSClass<% end_if %>">
    $SiteConfig.BodyScripts
    <div class="uk-offcanvas-content">
      <% include Header %>
      <main class="main-content-wrapper">
          $Layout
      </main>
      <% include Footer %>
    </div>
   <% include MetaDown %>
   <% include NavMobile %>
  </body>
</html>