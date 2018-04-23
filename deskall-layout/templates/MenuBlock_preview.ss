<div class="elemental-preview">
     
        <div class="elemental-preview__detail">
		    <% if Type == "content" %>
		    $Content
		    <% else_if Type == "logo" %>
		    <img src="$Logo.URL" width="150" />
        	<% else_if Type == "links" %>
        		<% if UseMenu %>
        			<% loop Menu.limit(2) %>
        		    	<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
        		    		<% if ShowSubLevels && Children %>
        		    		<div class="uk-navbar-dropdown uk-margin-remove">
        	                    <ul class="uk-nav uk-navbar-dropdown-nav">
        	                    	<% loop Children.limit(2) %>
        	                    	  <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
        	                    	<% end_loop %>
        	                    </ul>
        	                </div>
        	                <% end_if %>
        	            </li>
        		    <% end_loop %>
        		 <% end_if %>
                <% loop $activeLinks.limit(2) %>
                        $forTemplate
                <% end_loop %>
            <% end_if %>
        </div>
</div>
