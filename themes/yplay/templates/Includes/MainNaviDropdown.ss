<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">

	<ul class="uk-navbar-nav">
		<% loop Menu %>
		<li class="$LinkingMode $ExtraMenuClass <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
			<% if MenuSections.exists %>
			<div class="uk-navbar-dropdown uk-width-1-1">
				<div class="uk-navbar-dropdown-grid uk-child-width-1-{$MenuSections.count}" data-uk-grid>
				<% loop MenuSections %>
				<div>
					<div class="uk-padding-small">
						<div class="uk-flex uk-flex-left">
							<img width="60" height="60" src="$Image.URL">
							<div class="menu-section-title">$Title</div>
						</div>
						<div class="menu-section-text">$Text</div>
						<ul class="uk-nav uk-navbar-dropdown-nav">
							<% loop Links %>
							<li>
								    <a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr} <% if $LinkableLink.hasIcone %>data-uk-icon="icon: $LinkableLink.Icone"<% end_if %>><% if Label %><span class="uk-label $Background uk-margin-small-right uk-border-rounded">$Label</span><% end_if %>$LinkableLink.Title</a>
							</li>
							<% end_loop %>
						</ul>
					</div>
				</div>
				<% end_loop %>
			</div>
			<% end_if %>
		</li>
		<% end_loop %>
	</ul>		  
</div>