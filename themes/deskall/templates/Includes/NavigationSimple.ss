<nav class="main" itemprop="breadcrumb">
	<% loop $Menu(1) %>
	  <a href="$Link" title="$Title.XML" class="$LinkingMode">$MenuTitle.XML</a>
	<% end_loop %>
</nav>


