
<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	<% if $Locales %>
	<ul class="dk-nav-mobile-language uk-navbar-nav">
	<% loop $Locales %>
		<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link.ATT" <% if $LinkingMode != 'invalid' %>rel="alternate" hreflang="$LocaleRFC1766"<% end_if %>>$Title.XML</a></li>
	<% end_loop %>
	</ul>
	<% end_if %>
</div>