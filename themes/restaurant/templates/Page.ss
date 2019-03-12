<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
     $SiteConfig.GoogleAnalyticsCode
  </head>
  <body class="$ClassName">
    <div class="uk-grid-collapse" data-uk-grid>
      <div class="uk-width-1-1 uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
        <div data-uk-sticky>
          <div data-uk-height-viewport>
            <div class="uk-flex-1">
            <% include Header %>
            </div>
            <div class="uk-flex-auto">
            <% include Footer %>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-1 uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
        <div class="main-content-wrapper">
        $Layout
        </div>
      </div>
    

      <% include NavMobile %>
  

    <% if BodyScripts %>
      <% loop BodyScripts %>
      $Script
      <% end_loop %>
    <% end_if %>
  </body>
</html>
