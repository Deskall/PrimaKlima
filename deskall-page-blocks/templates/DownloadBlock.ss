
		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>

		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>
		
		<% if DownloadsTitle %><h3>$DownloadsTitle</h3><% end_if %>
		<div class="$FilesTextAlign $FilesColumns uk-grid-small" data-uk-grid>
		<% loop Files %>
		<div  class="uk-text-truncate">
			<a href="$URL" title="Download $Title" target="_blank">$Title</a>
		</div>
		<% end_loop %>
		</div>