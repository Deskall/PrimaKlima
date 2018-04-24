
<div class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;">
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox">
					<img src="$ContentImage.Fit(350,250).URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="350" height="250" >
				</a>
			</div>
			<div class="dk-text-content uk-width-2-3@m <% if Layout == "right" || Layout == "hover" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% else %>
			<div class="uk-width-1-1">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox">
					<% if $FullWidth %>
					<img src="$ContentImage.URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="$ContentImage.Resampled().Width" height="$ContentImage.Resampled().height" >
					<% else %>
					<img src="$ContentImage.ScaleWidth(1200).URL" alt="$ContentImage.AltTag($Title)" title="$ContentImage.TitleTag($Title)" width="$ContentImage.ScaleWidth(1200).Width" height="$ContentImage.ScaleWidth(1200).Height" >
					<% end_if %>
				</a>
			</div>
			<div class="dk-text-content uk-width-1-1 <% if Layout == "hover" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% end_if %>
	<% else %>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$HTML
	</div>
	<% end_if %>
</div>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="dk-list $FeaturesColumns $FeaturesTextAlign" data-uk-grid>
	<% loop activeFeatures %> 
	    <li><span class="dk-large-icon uk-text-large" data-uk-icon="icon: $Top.IconItem;">$Text</span></li>
	<% end_loop %>
	</ul>
<% end_if %>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>