
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox uk-position-relative uk-display-block" data-caption="$ContentImage.Description" >
					<img src="<% if ContentImage.getExtension == "svg" %>$ContentImage.URL<% else %>$ContentImage.ScaleWidth(350).URL<% end_if %>" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)" data-uk-parallax="opacity: 0,1; <% if Layout == right %>x: -100, 0<% else %>x: 100, 0<% end_if %>;  viewport: 0.5;">
					<div class="uk-position-absolute <% if Layout == right %>uk-position-right<% else_if Layout == left %>uk-position-left<% else_if Layout == above" %>uk-position-top<% else %>uk-position-bottom<% end_if %> shape-triangle shape-container">
					<div class="shape" data-uk-parallax="opacity: 0,1;"></div>
				</div>
				</a>
			</div>
			<div class="dk-text-content uk-width-2-3@m <% if Layout == "right" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>"><% if CollapseText %>
				<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
				<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
				<% else %>
				$HTML
				<% end_if %>
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
			<div class="dk-text-content uk-width-1-1 <% if Layout == "above" %>uk-flex-first<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>"><% if CollapseText %>
				<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
				<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
				<% else %>
				$HTML
				<% end_if %>
			</div>
		<% end_if %>
	<% else %>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		<% if CollapseText %>
				<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
				<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
				<% else %>
				$HTML
				<% end_if %>
	</div>
	<% end_if %>
</div>

<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>

<%-- <div class="uk-position-absolute uk-position-left shape-parallelogram">
<div class="shape"></div>
</div> --%>

