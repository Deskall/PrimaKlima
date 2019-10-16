<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
  </head>
  <body class="$ClassName $ExtraHeaderClass">
    $SiteConfig.BodyScripts
    <div class="uk-offcanvas-content">
      <% include Header %>
      <main class="main-content-wrapper">
          $Layout

          <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #offcanvas-usage">Open</button>

          <a href="#offcanvas-usage" uk-toggle>Open</a>

          <div id="offcanvas-usage" uk-offcanvas>
              <div class="uk-offcanvas-bar">

                  <button class="uk-offcanvas-close" type="button" uk-close></button>

                  <h3>Title</h3>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

              </div>
          </div>
          
      </main>

    
      <% include Footer %>

      
    </div>

    <% if BodyScripts %>
      <% loop BodyScripts %>
      $Script
      <% end_loop %>
    <% end_if %>
    $SiteConfig.GoogleAnalyticsCode
    $BodyCss
  </body>
</html>