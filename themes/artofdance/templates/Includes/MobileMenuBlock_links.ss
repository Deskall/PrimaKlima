<%-- <div class="$Layout $Class">

	<% if UseMenu %>
	<ul class="dk-nav-mobile uk-nav" data-uk-nav>
		<% if Title %>
		<li class="uk-nav-header">$Title</li>
		<% end_if %>
		<% loop Menu(1) %>
		<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>">
			<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
		
				<% if Top.ShowSubLevels && Children %>
				<ul class="uk-nav-sub">
					<% loop $Children %>
					<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass" >
						<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
						<% if Children %>
						<ul class="uk-nav-sub">
							<% loop $Children %>
							<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass" >
								<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
							</li>
							<% end_loop %>
						</ul>
						<% end_if %>
					</li>
					<% end_loop %>
				</ul>
				<% end_if %>
			
		</li>
		<% end_loop %>
	</ul>
	<% else %>
	<ul class="dk-nav-mobile uk-nav uk-margin-top dk-list">
		<% if Title %>
		<li class="uk-nav-header">$Title</li>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>
	<% end_if %>		  
</div>
 --%>
<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	 <ul class="dk-nav-mobile uk-nav <% if UseMenu %>$UseMenuOption<% end_if %>" data-uk-nav>
		<% if UseMenu %>
		<% loop Menu %>
		<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<% if Top.ShowSubLevels && Children %>
			<ul class="uk-nav uk-nav-parent-icon" data-uk-nav>
					<% loop Children %>
					<li class="$LinkingMode  <% if Children.exists %>uk-parent<% end_if %> <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active uk-open<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML"><% if not Children.exists %><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span><% end_if %>$MenuTitle.XML</a>
						<% if Top.ShowSubLevels && Children %>
						<ul class="uk-nav-sub">
								<% loop Children %>
								<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML"><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a></li>
								<% end_loop %>
						</ul>
						<% end_if %>
					</li>
					<% end_loop %>
			</ul>
			<% end_if %>
		</li>
		<% end_loop %>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>		  
</div>