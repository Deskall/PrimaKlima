<div class="$Layout $Class">

	<% if UseMenu %>
	<ul class="dk-nav-mobile uk-nav" data-uk-nav>
		<% if Title %>
		<li class="uk-nav-header">$Title</li>
		<% end_if %>
		<% loop Menu(1) %>
		<li class="$LinkingMode  ">
			<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
			<% if $Children %>
			<ul class="uk-nav-sub">
				<% loop $Children %>
				<li class="$LinkingMode <% if LinkingMode == "current" %>uk-active<% end_if %>" >
					<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
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