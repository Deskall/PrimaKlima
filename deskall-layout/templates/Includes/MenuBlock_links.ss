<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	<ul class="uk-navbar-nav <% if UseMenu %>$UseMenuOption<% end_if %>">
		<% if UseMenu %>
		<% loop Menu %>
		<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
			<% if Top.ShowSubLevels && Children %>
			<div class="uk-navbar-dropdown" data-uk-dropdown="position:bottom">
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
</div>