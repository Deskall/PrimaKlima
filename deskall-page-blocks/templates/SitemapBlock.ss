<ul data-uk-nav>
	<% loop $SitemapItems  %>
        <% if $Children %>
	    <li class="uk-parent <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>" >
	        <a href="$Link" title="$Title.XML"><strong>$MenuTitle.XML</strong></a>
	        <% with $Level(1) %>
	         <% if $Children %>
	        	<ul class="uk-nav-sub"> 
	        	<% loop $Children %>
	            <li <% if LinkingMode == "current" || LinkingMode == "section" %>class="uk-active"<% end_if %>>
	            	<a href="$Link" title="$Title.XML"><strong>$MenuTitle.XML</strong></a>
                    <% if $Children %>
                      <ul>
                        <% include SitemapSub %>
                      </ul>
                    <% end_if %>
                </li>
                <% end_loop %>
            	</ul>
              <% end_if %>
	        <% end_with %>
	    </li>
	    <% else %>
	    <li <% if LinkingMode == "current" || LinkingMode == "section" %>class="uk-active"<% end_if %>>
	        <a href="$Link" title="$Title.XML"><strong>$MenuTitle.XML</strong></a>
	    </li>
	   <% end_if %>
	<% end_loop %>
</ul>