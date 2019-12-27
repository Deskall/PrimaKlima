<div class="sidebar" data-uk-sticky="bottom:true;bottom-offset:50;offset:100">
	
		<% with Level(1) %>
			<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>>$MenuTitle.XML</a>
			<% if LinkingMode == "current" || LinkingMode == "section" %>
				<% if Children %>
				<ul class="uk-nav-default uk-nav uk-nav-parent-icon" data-uk-nav>
					<% loop $Children %>
					<li class="$LinkingMode <% if Children.exists %>uk-parent<% end_if %> <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active uk-open<% end_if %> $ExtraMenuClass" >
						<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>>$MenuTitle.XML</a>
						<% if Children %>
						<ul class="uk-nav-sub">
							<% loop $Children %>
							<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> $ExtraMenuClass" >
								<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right uk-display-inline-block" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
							</li>
							<% end_loop %>
						</ul>
						<% end_if %>
					</li>
					<% end_loop %>
				</ul>
				<% end_if %>
			<% end_if %>
		<% end_with %>
</div>