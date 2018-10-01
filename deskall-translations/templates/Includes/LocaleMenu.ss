<% if $Locales %>
<div class="uk-navbar-right uk-visible@m dk-nav-top">
	<ul class="uk-navbar-nav">
	<% loop $Locales %>
		<li class="$LinkingMode">
			<a href="$Link.ATT" <% if $LinkingMode != 'invalid' %>rel="alternate" hreflang="$LocaleRFC1766"<% end_if %>>$Title.XML</a>
		</li>
	<% end_loop %>
	</ul>
</div>
<% end_if %>
