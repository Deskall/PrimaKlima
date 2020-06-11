
<div <% if ContentImage %>class="uk-flex $BlockVerticalAlignment" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<% if ContentImage %>
		<% if Layout == right || Layout == left %>
			<div class="uk-width-1-3@m">
				<a href="$ContentImage.getSourceURL" class="dk-lightbox" data-caption="$ContentImage.Description" >
					<img src="<% if ContentImage.getExtension == "svg" %>$ContentImage.URL<% else %>$ContentImage.FitMax(350,250).URL<% end_if %>" alt="$AltTag($ContentImage.Description, $ContentImage.Name, $Title)" title="$TitleTag($ContentImage.Name,$Title)">
				</a>
			</div>
			<div class="dk-text-content uk-width-2-3@m <% if Layout == "right" %>uk-flex-first@s<% end_if %> $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">$HTML
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


			<div class="uk-panel uk-background-muted uk-padding-small">
				<% if $Message %>
				<p>$Message</p>
				<% end_if %>
				<% if not activePLZ %>
					<form method="POST" action="{$getPage.Link}plz-speichern" class="form-std plz-form">
						<div class="uk-flex uk-flex-left uk-flex-top">
						   <div>
						        <input class="uk-input uk-text-center" type="text" name="plz-choice" required="required" placeholder="Ihrer PLZ">
						   </div>
						   <button class="uk-button uk-button-primary" type="submit">Region prüfen</button>
						</div>
					</form>
				<% else %>
					<p class="uk-text-muted">Ihre Region: $activePLZ.Code - $activePLZ.City <a href="{$getPage.Link}plz-loeschen" class="uk-padding-remove" title="Region löschen" data-uk-tooltip="<%t PLZ.CLEAR 'Region löschen' %>"><i class="icon icon-close-circled uk-text-muted"></i></a></p>
				<% end_if %>
			</div>

			<% if $TVOffer %>
			<div class="uk-panel">
				<% with $TVOffer %>
					<h3 class="uk-margin-top uk-margin-remove-bottom">Ihre TV-Angebot: $Title</h3>
					<% if Image %>
					<div class="uk-flex uk-flex-middle" data-uk-grid>
						<div class="uk-width-1-2@m uk-1-3@l uk-width-1-4@xl">
							$Image.ScaleWidth(350)
						</div>
						<div class="uk-width-1-2@m uk-2-3@l uk-width-3-4@xl">
							$Inhalt
						</div>
					</div>
					<% else %>
					$Inhalt
					<% end_if %>
				<% end_with %>
			</div>
			<% end_if %>
