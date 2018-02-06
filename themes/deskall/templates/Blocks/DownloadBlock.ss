<div class="download-block">
	<% if $Content %>
	<div class="download-block-text">
		$Content
	</div>
	<% end_if %>
	<% if $Files  %>
	<div class="download-block-items">
	    <% loop $Files.Sort('SortOrder') %>
	        <a href="$URL" target="_blank">$Title</a>
	    <% end_loop %>
	</div>
	<% end_if %>
</div>