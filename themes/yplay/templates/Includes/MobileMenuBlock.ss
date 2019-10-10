<ul class="dk-nav-mobile uk-nav">
	<% if SiteConfig.Facebook %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Facebook" data-uk-icon="facebook" target="_blank"></a></li>
	<% end_if %>
	<% if SiteConfig.Twitter %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Twitter" data-uk-icon="twitter" target="_blank"></a></li>
	<% end_if %>
	<% if SiteConfig.Linkedin %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Linkedin" data-uk-icon="linkedin" target="_blank"></a></li>
	<% end_if %>
	<% if SiteConfig.Xing %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Xing" data-uk-icon="xing" target="_blank"></a></li>
	<% end_if %>
</ul>