<div class="countdown-container uk-margin">
	<div class="uk-grid-small uk-child-width-auto" uk-grid uk-countdown="date: $Countdown">
	    <div>
	        <div class="uk-countdown-number uk-countdown-days"></div>
	        <div class="uk-countdown-label  uk-text-center">Tage</div>
	    </div>
	    <div class="uk-countdown-separator">:</div>
	    <div>
	        <div class="uk-countdown-number uk-countdown-hours"></div>
	        <div class="uk-countdown-label  uk-text-center">Stunden</div>
	    </div>
	    <div class="uk-countdown-separator">:</div>
	    <div>
	        <div class="uk-countdown-number uk-countdown-minutes"></div>
	        <div class="uk-countdown-label  uk-text-center">Minuten</div>
	    </div>
	    <div class="uk-countdown-separator">:</div>
	    <div>
	        <div class="uk-countdown-number uk-countdown-seconds"></div>
	        <div class="uk-countdown-label  uk-text-center">Sekunden</div>
	    </div>
	</div>
</div>
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description" >
					<img src="<% if ContentImage.getExtension == "svg" %>$ContentImage.URL<% else %>$ContentImage.ScaleWidth(350).URL<% end_if %>" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
				</a>
			</div>
			<div class="dk-text-content uk-width-2-3@m <% if Layout == "right" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
			</div>
		<% else %>
			<div class="uk-width-1-1">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description">
					<% if $FullWidth %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
						<% else %>
							<%-- $ContentImage.Content($ContentImage.ID,2500,$Title) --%>
							<img src="$ContentImage.FitMax(1500,1500).URL" data-src="$ContentImage.FitMax(500,500).URL"
							     data-srcset="$ContentImage.FitMax(500,500).URL 500w,
							                  $ContentImage.FitMax(1000,1000).URL 1000w,
							                  $ContentImage.FitMax(1500,1500).URL 1500w,
							                  $ContentImage.FitMax(2500,2500).URL 2500w"
							     sizes="(min-width: 1700px) 2500px,(min-width: 1000px) 1500px,(min-width: 650px) 1000px, 100vw"  alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" data-uk-img>
						<% end_if %>
					<% else %>
						<% if ContentImage.getExtension == "svg" %>
							<img src="$ContentImage.URL" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
						<% else %>
							<%-- $ContentImage.Content($ContentImage.ID,1200,$Title) --%>
							<img src="$ContentImage.FitMax(1500,1500).URL" data-src="$ContentImage.FitMax(500,500).URL"
							     data-srcset="$ContentImage.FitMax(500,500).URL 500w,
							                  $ContentImage.FitMax(1000,1000).URL 1000w,
							                  $ContentImage.FitMax(1500,1500).URL 1200w"
							     sizes="(min-width: 1200px) 1200px,(min-width: 650px) 1000px, 100vw" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" data-uk-img>
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

