<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">	  
    <ul class="uk-nav-default uk-nav-parent-icon <% if UseMenu %>$UseMenuOption<% end_if %>" data-uk-nav>
	 	<% if UseMenu %>
			<% loop Menu %>
		        <li class="<% if Top.ShowSubLevels && Children %>uk-parent<% end_if %> $LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a>
		        	<% if Top.ShowSubLevels && Children %>
		        	<ul class="uk-nav-sub">
		        		<% loop Children %>
			                <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a></li>
			                <% if Children %>
			                <ul class="uk-nav-sub">
			                	<% loop Children %>
								<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %> title="$Title.XML">$MenuTitle.XML</a></li>
								<% end_loop %>
							</ul>
							<% end_if %>
						<% end_loop %>
		            </ul>
		        	<% end_if %>
		        </li>
		    <% end_loop %>
		<% else %>
		    <% loop $activeLinks %>
			$forTemplate
			<% end_loop %>
		<% end_if %> 
	</ul>
</div>

<div class="uk-width-1-2@s uk-width-2-5@m">
    <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
        <li class="uk-active"><a href="#">Active</a></li>
        <li class="uk-parent">
            <a href="#">Parent</a>
            <ul class="uk-nav-sub">
                <li><a href="#">Sub item</a></li>
                <li>
                    <a href="#">Sub item</a>
                    <ul>
                        <li><a href="#">Sub item</a></li>
                        <li><a href="#">Sub item</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="uk-parent">
            <a href="#">Parent</a>
            <ul class="uk-nav-sub">
                <li><a href="#">Sub item</a></li>
                <li><a href="#">Sub item</a></li>
            </ul>
        </li>
    </ul>
</div>