<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	 <ul class="dk-nav-mobile uk-nav uk-nav-parent-icon <% if UseMenu %>$UseMenuOption<% end_if %>" data-uk-nav>
		<% if UseMenu %>
		<% loop Menu %>
		<li class="level-1 $LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> <% if Top.ShowSubLevels && Children %>uk-parent<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<div class="uk-navbar-dropdown uk-width-1-1">
				<div class="uk-child-width-1-4@m" data-uk-grid>
				<% loop Children %>
					<div>
						<div class="category-image">$Image.ScaleHeight(100)</div>
						<div class="category-title"><a href="$Link">$MenuTitle.XML</a></div>
						<div class="uk-padding-small">
							<% loop Children %>
							<div class="category-title"><a href="$Link">$MenuTitle.XML</a></div>
							<% end_loop %>
						</div>
					</div>
				<% end_loop %>
				</div>
			</div>
			<%-- <% if Top.ShowSubLevels && Children %>
			<ul class="uk-nav-sub">
					<% loop Children %>
					<li class="level-2 $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> <% if Top.ShowSubLevels && Children %>uk-parent<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
						<% if Top.ShowSubLevels && Children %>
						<ul class="uk-nav-sub">
								<% loop Children %>
								<li class="level-3 $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a></li>
								<% end_loop %>
						</ul>
						<% end_if %>
					</li>
					<% end_loop %>
			</ul>
			<% end_if %> --%>
		</li>
		<% end_loop %>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>		  
</div>