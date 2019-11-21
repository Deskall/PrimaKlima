<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
$MetaTags(false)

<!-- StructuredData -->
$StructuredData
$StructuredBreadcrumbs
$CustomStructuredData
<!-- End StructuredData -->

<% base_tag %>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<link rel="apple-touch-icon" sizes="180x180" href="$ThemeDir/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="$ThemeDir/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="$ThemeDir/favicon-16x16.png">
<link rel="manifest" href="$ThemeDir/site.webmanifest">
<link rel="mask-icon" href="$ThemeDir/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta name="msapplication-config" content="$ThemeDir/browserconfig.xml">

<% if isLive %>
	<script async defer src="$ThemeDir/javascript/main.min.js"></script>
	$HeadCss
<% else %>
    <script src="$ThemeDir/javascript/main.js"></script>
	<link rel="stylesheet" type="text/css" href="$ThemeDir/css/body.min.css" />
<% end_if %>

<% if headScripts %>
	<% loop headScripts %>
	$Script
	<% end_loop %>
<% end_if %>

$SiteConfig.HeadScripts