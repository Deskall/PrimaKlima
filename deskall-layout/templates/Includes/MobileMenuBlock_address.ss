<div class="$Layout $Class">

<ul class="uk-list uk-margin-remove-top">
	<% if $SiteConfig.Address != "" %>
	<li>
		<strong>$SiteConfig.AddressTitle</strong><br/>
			<% if $SiteConfig.Address %>
			$SiteConfig.Address<br/>
			<% end_if %>
			<% if $SiteConfig.Code %>
			$SiteConfig.Code - $SiteConfig.City<br/>
			<% end_if %>
			<% if $SiteConfig.Country %>
			$SiteConfig.Country
			<% end_if %>
</li>
<% end_if %>
<% if SiteConfig.Phone %>
<li>
	Tel. $SiteConfig.Phone
	<% if SiteConfig.Fax %>
	<br/>Fax $SiteConfig.Fax
	<% end_if %>
	<% if SiteConfig.Mobile %>
	<br/>$SiteConfig.Mobile
	<% end_if %>
</li>
<% end_if %>


<% if SiteConfig.Email %>
<li>
	$SiteConfig.Email
</li>
<% end_if %>

<% if SiteConfig.Facebook || SiteConfig.Twitter || SiteConfig.Linkedin || SiteConfig.Xing || SiteConfig.Instagramm %>
<li>
	<ul class="uk-iconnav uk-padding-remove uk-margin-remove">
		<% if SiteConfig.Facebook %>
		<li><a href="$SiteConfig.Facebook" target="_blank" data-uk-icon="facebook"></a></li>
		<% end_if %>
		<% if SiteConfig.Twitter %>
		<li><a href="$SiteConfig.Twitter" target="_blank" data-uk-icon="twitter"></a></li>
		<% end_if %>
		<% if SiteConfig.Linkedin %>
		<li><a href="$SiteConfig.Linkedin" target="_blank" data-uk-icon="linkedin"></a></li>
		<% end_if %>
		<% if SiteConfig.Xing %>
		<li><a href="$SiteConfig.Xing" target="_blank" data-uk-icon="xing"></a></li>
		<% end_if %>
		<% if SiteConfig.Instagram %>
		<li><a href="$SiteConfig.Instagram" target="_blank" data-uk-icon="instagram"></a></li>
		<% end_if %>
	</ul>
</li>
<% end_if %>
</ul>
</div>