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
<% include Favicon %>

<% if isLive %>
	<script async defer src="$ThemeDir/javascript/main.min.js?v=$LastChangeJS"></script>
	$HeadCss
<% else %>
    <script src="$ThemeDir/javascript/main.js"></script>
	<link rel="stylesheet" type="text/css" href="$ThemeDir/css/head.min.css" />
<% end_if %>

<% if headScripts %>
	<% loop headScripts %>
	$Script
	<% end_loop %>
<% end_if %>

$SiteConfig.HeadScripts