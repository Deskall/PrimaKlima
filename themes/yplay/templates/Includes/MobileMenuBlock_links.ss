<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	 <ul class="dk-nav-mobile uk-nav uk-nav-parent-icon <% if UseMenu %>$UseMenuOption<% end_if %>" data-uk-nav>
		<% if UseMenu %>
		<% loop Menu %>
		<li class="level-1 $LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> <% if Top.ShowSubLevels && Children %>uk-parent<% else_if MenuSections.exists %>uk-parent<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<% if MenuSections.exists %>
				<ul class="uk-nav-sub">
					<% loop MenuSections %>
					<li class="menu-section">
						<div class="uk-grid-small" data-uk-grid>
							<div class="uk-width-1-5 uk-text-center"><img width="40" height="40" src="$Image.URL" class="menu-icon"></div>
							<div class="uk-width-4-5">
								<div class="menu-section-title">$Title</div>
								<div class="menu-section-text">$Text</div>
							</div>
						</div>
						<div class="menu-section-links">
							<ul class="uk-nav uk-padding-remove">
								<% loop Links %>
								<li>
									<div class="uk-grid-small" data-uk-grid>
										<div class="uk-width-1-5"><% if Label %><span class="uk-label $Background uk-margin-small-right uk-border-rounded">$Label</span><% end_if %></div>
										<div class="uk-width-4-5">
										    <a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr} <% if $LinkableLink.hasIcone %>data-uk-icon="icon: $LinkableLink.Icone"<% end_if %>>
										    	$LinkableLink.Title
										    </a>
										</div>
									</div>
								</li>
								<% end_loop %>
							</ul>
						</div>
					</li>
					
						
					
					<% end_loop %>
				</ul>
				
			<% else_if Top.ShowSubLevels && Children %>
			<ul class="uk-nav-sub">
					<% loop Children %>
					<li class="menu-section level-2 $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %> <% if Top.ShowSubLevels && Children %>uk-parent<% end_if %> $ExtraMenuClass"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
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
			<% end_if %>
		</li>
		<% end_loop %>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>		  
</div>