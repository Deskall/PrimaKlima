<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	 <ul class="dk-nav-mobile uk-nav uk-nav-parent-icon <% if UseMenu %>$UseMenuOption<% end_if %>" data-uk-nav>
		<% if UseMenu %>
		<% loop Menu %>
		<li class="level-1 $LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> <% if Top.ShowSubLevels && Children %>uk-parent<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<% if MenuSections.exists %>
				
					<% loop MenuSections %>
					<div class="uk-flex uk-flex-left">
						<img width="60" height="60" src="$Image.URL" >
						<div>
							<div class="menu-section-title">$Title</div>
							<div class="menu-section-text">$Text</div>
						</div>
					</div>
					
						<ul class="uk-nav">
							<% loop Links %>
							<li>
								    <a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr} <% if $LinkableLink.hasIcone %>data-uk-icon="icon: $LinkableLink.Icone"<% end_if %>>
								    	<% if Label %><span class="uk-label $Background uk-margin-small-right uk-border-rounded">$Label</span><% end_if %>$LinkableLink.Title
								    </a>
							</li>
							<% end_loop %>
						</ul>
					
					<% end_loop %>
				</div>
		<%-- 	<% else_if Top.ShowSubLevels && Children %>
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
			</ul> --%>
			<% end_if %>
		</li>
		<% end_loop %>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>		  
</div>