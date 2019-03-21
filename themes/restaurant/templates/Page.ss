<!doctype html>
<html lang="$ContentLocale" dir="ltr">
  <head>
     <% include Meta %>
     $SiteConfig.GoogleAnalyticsCode
  </head>
  <body class="$ClassName">
    <div class="uk-grid-collapse" data-uk-grid>
      <div class="uk-width-1-1 uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl">
        <div data-uk-sticky class="uk-visible@m">
          <div class="uk-box-shadow-large">
            <div data-uk-height-viewport="offset-top: true; offset-bottom: true;">
            <% include Header %>
            </div>
            <div>
            <% include Footer %>
            </div>
          </div>
        </div>
        <nav class="uk-navbar uk-navbar-container uk-margin">
            <div class="uk-navbar-left">
                <a class="uk-navbar-toggle" href="#">
                    <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span>
                </a>
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
