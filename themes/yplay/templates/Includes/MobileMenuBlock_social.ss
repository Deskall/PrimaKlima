<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	<ul class="uk-iconnav">
		<% if SiteConfig.Facebook %>
		<li><a href="$SiteConfig.Facebook" data-uk-icon="facebook" target="_blank"></a></li>
		<% end_if %>
		<% if SiteConfig.Twitter %>
		<li><a href="$SiteConfig.Twitter" data-uk-icon="twitter" target="_blank"></a></li>
		<% end_if %>
		<% if SiteConfig.Linkedin %>
		<li><a href="$SiteConfig.Linkedin" data-uk-icon="linkedin" target="_blank"></a></li>
		<% end_if %>
		<% if SiteConfig.Xing %>
		<li><a href="$SiteConfig.Xing" data-uk-icon="xing" target="_blank"></a></li>
		<% end_if %>
	</ul>
</div>