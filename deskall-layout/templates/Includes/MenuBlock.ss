<div class="$Layout $Width <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	<% if Type == "links" %>
	<ul class="uk-navbar-nav">
		<% if UseMenu %>
			<% loop Menu %>
		    	<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
		    		<% if Children %>
		    		<div class="uk-navbar-dropdown uk-margin-remove">
	                    <ul class="uk-nav uk-navbar-dropdown-nav">
	                    	<% loop Children %>
	                    	  <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
	                    	<% end_loop %>
	                    </ul>
	                </div>
	                <% end_if %>
	            </li>
		    <% end_loop %>
		 <% end_if %>
		<% loop $activeLinks %>
			$forTemplate
		<% end_loop %>
	</ul>		  
	<% end_if %>
	<% if Type == "logo" %>
	  <a href="/" class="uk-navbar-item uk-logo"><img src="$Logo.URL" alt="$SiteConfig.Title Logo" title="Home" /></a>
	<% end_if %>
</div>