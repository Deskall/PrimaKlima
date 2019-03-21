<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
     $SiteConfig.GoogleAnalyticsCode
  </head>
  <body class="$ClassName">
    <div class="uk-grid-collapse" data-uk-grid>
      <div class="uk-width-1-1 uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
        <div id="main-navigation" data-uk-sticky class="uk-visible@m">
          <div class="uk-box-shadow-large">
            <div data-uk-height-viewport="offset-top: true; offset-bottom: true;">
            <% include Header %>
            </div>
            <div>
            <% include Footer %>
            </div>
          </div>
        </div>
        <nav class="uk-navbar uk-padding dk-background-header">
            <div class="uk-navbar-right uk-hidden@m">
              <button class="uk-button uk-padding-remove dk-toggle-mobile-menu" type="button" data-uk-navbar-toggle-icon data-uk-toggle="target: #offcanvas-flip"><span class="uk-margin-small-right">Menu</span></button>
            </div>
        </nav>
      </div>
      <div class="uk-width-1-1 uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl">
        <div class="main-content-wrapper">
        $Layout
        </div>
      </div>
    
      <div class="uk-hidden@m uk-width-1-1">
        <% include Footer %>
      </div>
      <% include NavMobile %>
  

    <% if BodyScripts %>
      <% loop BodyScripts %>
      $Script
      <% end_loop %>
    <% end_if %>
  </body>
</html>
