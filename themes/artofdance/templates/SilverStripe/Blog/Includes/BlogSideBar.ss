<div class="sidebar" data-uk-sticky="bottom:true;bottom-offset:50;offset:100">

		<% with Level(1) %>
			<a href="$Link" class="uk-text-bold" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>>$MenuTitle.XML</a>
			<% if LinkingMode == "current" || LinkingMode == "section" %>
				<% if BlogPosts %>
				<ul class="uk-nav-default uk-nav uk-nav-parent-icon" data-uk-nav>
					<% loop $BlogPosts.sort('ID') %>
					<li class="$LinkingMode <% if Children.exists %>uk-parent<% end_if %> <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active uk-open<% end_if %> $ExtraMenuClass" >
						<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>>$MenuTitle.XML</a>
					</li>
					<% end_loop %>
				</ul>
				<% end_if %>
			<% end_if %>
		<% end_with %>
	
</div>