<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
     <meta name="apple-itunes-app" content="app-id=1460260115">
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
    <% if Overlay.exists %>
    Hello
      <% with Overlay %>
        <% include Overlay %>
      <% end_with %>
    <% end_if %>
   <% include MetaDown %>
  </body>
</html>