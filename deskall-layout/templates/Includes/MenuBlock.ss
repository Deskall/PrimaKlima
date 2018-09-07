<div class="$Layout $Width <% if Type != "logo" %><% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %><% end_if %> $Class">
	<% if Type == "links" %>

	<ul class="uk-navbar-nav <% if UseMenu %>$UseMenuOption<% end_if %>">
		<% if UseMenu %>
		<% loop Menu %>
		<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			<% if Top.ShowSubLevels && Children %>
			<div class="uk-navbar-dropdown uk-margin-remove">
				<ul class="uk-nav uk-navbar-dropdown-nav">
					<% loop Children %>
					<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
					<% end_loop %>
				</ul>
			</div>
			<% end_if %>
		</li>
		<% end_loop %>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>		  
	<% end_if %>
	<% if Type == "logo" %>
	<a href="/" class="uk-navbar-item uk-logo">
		<% if $Logo.getExtension == "svg" %>
		<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" />
		<% else %>
		<img src="$Logo.ScaleWidth(150).URL" data-srcset="$Logo.ScaleWidth(150).URL 150w, $Logo.ScaleWidth(250).URL 250w, $Logo.ScaleWidth(350).URL 350w" data-sizes="150w, (min-width:650px) 250w, (min-width:1200px) 350w" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"  data-uk-img/>
		<% end_if %>
	</a>
	<% end_if %>
	<% if Type == "form" %>
	
	<% end_if %>
</div>