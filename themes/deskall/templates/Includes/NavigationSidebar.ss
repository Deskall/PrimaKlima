
<aside class="col w-3 sidebar">
<% if $Menu(2) %>
	<% with $Level(1) %>
	<h4><a href="$Link">$MenuTitle.XML</a></h4>
	<% end_with %>
	<nav class="lvl-2">
		<% if $CurrentLevel > 2 %>
			<p>...</p>
		    <% loop $Menu($Parent.CurrentLevel) %>
		        <a href="$Link" title="$Title.XML" class="$LinkingMode" >$MenuTitle.XML</a>
		        <% if $Children %>
		        	<% include SubMenu %>
			    <% end_if %>
		    <% end_loop %>
		<% else_if $CurrentLevel == 2 %>
			<% loop $Menu(2) %>
		        <a href="$Link" title="$Title.XML" class="$LinkingMode" >$MenuTitle.XML</a>
		          <% if $Children %>
		        	<nav class="lvl-$CurrentLevel">
						<% loop $Children %>
							<a href="$Link" title="$Title.XML" class="$LinkingMode" >$MenuTitle.XML</a>
						<% end_loop %>
					</nav>
			    <% end_if %>
		    <% end_loop %>
	    <% else %>
		    <% loop $Menu(2) %>
		        <a href="$Link" title="$Title.XML" class="$LinkingMode" >$MenuTitle.XML</a>
		    <% end_loop %>
		<% end_if %>
	</nav>
<% end_if %>
</aside>


