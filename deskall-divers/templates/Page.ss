<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName $ExtraCSSClass">
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