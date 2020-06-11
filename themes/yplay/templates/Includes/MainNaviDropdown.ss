<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	<ul class="uk-navbar-nav">
		<% loop Menu %>
		<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<% if activeMenuSections.exists %>
			<div class="uk-navbar-dropdown uk-box-shadow-medium uk-width-1-1">
				<div class="uk-navbar-dropdown-grid uk-child-width-1-{$MenuSections.count}" data-uk-grid>
					<% loop activeMenuSections %>
					<div>
						<div class="uk-padding-small">
							<div class="uk-flex uk-margin">
								<% if Image %><img width="30" height="30"  class="menu-section-img" <% if $Image.getExtension == "svg" %>src="$Image.URL"<% else %>src="$Image.FitMax(30,30).URL"<% end_if %>><% end_if %>
								<div class="<% if Image %>uk-margin-small-left<% end_if %> menu-section-title">$Title</div>
							</div>
							<div class="menu-section-text">$Text</div>
							<ul class="uk-nav uk-navbar-dropdown-nav menu-section-links">
								<% loop Links %>
								<li>
									    <a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr}>$LinkableLink.Title<% if $LinkableLink.hasIcone %><span class="uk-margin-small-left" data-uk-icon="icon: $LinkableLink.Icone"></span><% end_if %><% if Label %><span class="uk-label $Background uk-margin-small-left uk-border-rounded">$Label</span><% end_if %></a>
								</li>
								<% end_loop %>
							</ul>
						</div>
					</div>
					<% end_loop %>
				</div>
			</div>
			<% end_if %>
		</li>
		<% end_loop %>
	</ul>		  
</div>