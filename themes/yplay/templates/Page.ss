<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName $Level(1).ExtraCSSClass">
    $SiteConfig.BodyScripts
    <div class="uk-offcanvas-content">
      <% include Header %>
      <main class="main-content-wrapper">
          $Layout
      </main>
      <% include Footer %>
      <% include Modals %>
    </div>
   <% include MetaDown %>
  </body>
</html>