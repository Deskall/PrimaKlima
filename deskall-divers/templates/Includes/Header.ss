<% if SiteConfig.Theme == "standard" %>
	<% include Header_standard %>
<% else_if SiteConfig.Theme == "grid" %>
	<% include Header_grid %>
<% end_if %>

