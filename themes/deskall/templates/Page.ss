<!DOCTYPE html>
<html lang="$ContentLocale">
  <head>
    <% include Meta %>
    <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
  </head>
  <body class="hyphenate" itemscope itemtype="http://schema.org/WebPage">
    <% include Header %>
    $Layout
    <% include Footer %>
    
    $ExtraScript
    <% if  $isLive %>
     $SiteConfig.GoogleAnalyticsCode
     <script defer src="$ThemeDir/js/main.min.js"></script>
     <style>$BodyCss</style>
    <% else %>
      <script defer src="$ThemeDir/js/main.js"></script>
      <% if $isDev %>
      <% else %>
      <link rel="stylesheet" type="text/css" href="$ThemeDir/css/body.min.css" />
      <% end_if %>
    <% end_if %>
    $Metadaten
  </body>
</html>
