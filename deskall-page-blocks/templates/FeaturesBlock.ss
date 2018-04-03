
<div class="uk-flex" data-uk-grid data-uk-lightbox>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL">
					<img src="$ContentImage.Fit(350,250).URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="350" height="250" >
				</a>
			</div>
			<div class="uk-width-2-3@m <% if Layout == "right" || Layout == "hover" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% else %>
			<div class="uk-width-1-1">
				<a href="$ContentImage.getSourceURL">
					<% if $FullWidth %>
					<img src="$ContentImage.URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="$ContentImage.Resampled().Width" height="$ContentImage.Resampled().height" >
					<% else %>
					<img src="$ContentImage.ScaleWidth(1200).URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="$ContentImage.ScaleWidth(1200).Width" height="$ContentImage.ScaleWidth(1200).Height" >
					<% end_if %>
				</a>
			</div>
			<div class="uk-width-1-1 <% if Layout == "hover" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% end_if %>
	<% else %>
	<div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	<% end_if %>
</div>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="uk-list uk-list-large dk-list $FeaturesColumns $FeaturesTextAlign">
	<% loop activeFeatures %> 
	    <li data-uk-icon="icon: $Top.IconItem;" class="dk-large-icon uk-text-large uk-width-1-1">$Text</li>
	<% end_loop %>
	</ul>
<% end_if %>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>