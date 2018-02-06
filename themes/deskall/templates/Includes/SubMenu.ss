<nav class="lvl-$CurrentLevel">
	<% loop $Children %>
		<a href="$Link" title="$Title.XML" class="$LinkingMode" >$MenuTitle.XML</a>
		<% if $Children %>
			<nav class="lvl-$CurrentLevel">
				<% loop $Children %>
					<a href="$Link" title="$Title.XML" class="$LinkingMode" >$MenuTitle.XML</a>
				<% end_loop %>
			</nav>
		<% end_if %>
	<% end_loop %>
</nav>