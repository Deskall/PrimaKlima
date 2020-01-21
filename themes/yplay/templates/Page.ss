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

          <% include ScrollUp %>
      </main>
      <% if $ID > 0 %> 
        <% include Sidebar %> 
        <% include Modals %>
      <% end_if %>
      <% include Footer %>
     

    </div>
   <% include MetaDown %>
  </body>
</html>