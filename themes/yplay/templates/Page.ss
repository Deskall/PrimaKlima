<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
     <meta name="apple-itunes-app" content="app-id=1460260115, affiliate-data=myAffiliateData, app-argument=$Link">
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
   <div class="uk-position-bottom">
    <button id="smart-app" class="uk-button button-PrimaryBackground">Smartapp</button>
   </div>
  </body>
</html>