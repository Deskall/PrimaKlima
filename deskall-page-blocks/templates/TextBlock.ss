
<div <% if ContentImage %>data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description" >
					<img src="<% if ContentImage.getExtension == "svg" %>$ContentImage.URL<% else %>$ContentImage.ScaleWidth(350).URL<% end_if %>" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)" width="350" height="$HeightForWidth(350,$ContentImage.Width, $ContentImage.Height)" >
				</a>
			</div>
			<div class="dk-text-content uk-width-2-3@m <% if Layout == "right" || Layout == "above" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% else %>
			<div class="uk-width-1-1">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description">
					<% if $FullWidth %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)" width="2500" height="$HeightForWidth(2500,$ContentImage.Width, $ContentImage.Height)">
						<% else %>
							$ContentImage.Content($ContentImage.ID,2500,$Title)
						<% end_if %>
					<% else %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)" width="1200" height="$HeightForWidth(1200,$ContentImage.Width, $ContentImage.Height)" >
						<% else %>
							$ContentImage.Content($ContentImage.ID,1200,$Title)
						<% end_if %>
					<% end_if %>
				</a>
			</div>
			<div class="dk-text-content uk-width-1-1 <% if Layout == "above" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% end_if %>
	<% else %>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	<% end_if %>
	
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
