
		<div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>

		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>
		
		<% if DownloadsTitle %><h3>$DownloadsTitle</h3><% end_if %>
		<div class="$FilesTextAlign $FilesColumns" data-uk-grid>
		<% loop Files %>
		<div>
			<a href="$URL" title="Download $Title">$Title</a>
		</div>
		<% end_loop %>
		</div>