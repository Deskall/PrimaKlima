<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	<ul class="uk-navbar-nav <% if UseMenu %>$UseMenuOption<% end_if %>">
		<% if UseMenu %>
		<% loop Menu %>
		<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<% if ClassName == "ProductOverviewPage" %>
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
			<% else_if Top.ShowSubLevels && Children %>
			<div class="uk-navbar-dropdown">
				<ul class="uk-nav uk-navbar-dropdown-nav">
					<% loop Children %>
					<li class="uk-position-relative $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML<% if Top.ShowSubLevels && Children %><div id="link-{$ID}" class="uk-position-center-right uk-position-small"><i class="fa fa-chevron-right uk-margin-small-left"></i></div><% end_if %></a>
						<% if Top.ShowSubLevels && Children %>
						<div class="second" data-uk-dropdown="pos:right-top">
							<ul class="uk-nav uk-dropdown-nav">
								<% loop Children %>
								<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
								</li>
								<% end_loop %>
							</ul>
						</div>
						<% end_if %>
					</li>
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