
<div <% if ContentImage %>data-uk-grid<% end_if %> data-uk-lightbox>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description">
					<img src="<% if ContentImage.getExtension == "svg" %>$ContentImage.URL<% else %>$ContentImage.FocusFillMax(350,250).URL<% end_if %>" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="350" height="250" >
				</a>
			</div>
			<div class="uk-width-2-3@m <% if Layout == "right" || Layout == "above" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% else %>
			<div class="uk-width-1-1">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description">
					<% if $FullWidth %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="2500" height="2500">
						<% else %>
							$ContentImage.Content(2500,$Title)
						<% end_if %>
					<% else %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="1200" height="1200" >
						<% else %>
							$ContentImage.Content(1200,$Title)
						<% end_if %>
					<% end_if %>
				</a>
			</div>
			<div class="uk-width-1-1 <% if Layout == "above" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% end_if %>
	<% else %>
	<div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	<% end_if %>
	
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
