<% if Title || isPrimary %>
<section class="uk-section $SectionPadding">
		<div class="uk-container $TextAlign <% if $FullWidth %>uk-container-expand<% end_if %>">
			<% if not $isChildren %><div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
				<div class="$Width"><% end_if %>
					<% if isPrimary %>
						<h1 class="$TitleAlign">$getPage.Title</h1>
					<% else %>
						<% if Title && $ShowTitle %>
							<% if $isChildren %>
								<h3 class="$TitleAlign">$Title</h3>
							<% else %>
								<h2 class="$TitleAlign">$Title</h2>
							<% end_if %>
						<% end_if %>
					<% end_if %>
				<% if not $isChildren %>
				</div>
			</div>
			<% end_if %>
		</div>
</section>
<% end_if %>
<% if activeEvents.exists %>
	<% loop activeEvents %>
	<section class="uk-section uk-padding <% if odd %>uk-background-muted<% end_if %>">
		<div class="uk-container">
			
				<div class="uk-grid-small" data-uk-grid>
					<% if Images.first %>
					<div class="uk-width-1-3@m">
						<img src="$Images.first.FocusFill(250,250).URL" data-uk-img class="uk-border-circle" alt="$Images.first.Alt" />
					</div>
					<div class="uk-width-2-3@m">
					<% else %>
					<div>
					<% end_if %>
					    <h3 class="uk-card-title">$Title</h3>
					        <div class="uk-margin uk-flex uk-flex-left uk-text-small">
					        	<% if activeDates.Exists %>
					        		<% with activeDates.first %>
					    	    	<strong class="uk-margin-right"><%t Event.NextCourse 'Nächster Kurse:' %></strong><strong class="uk-margin-right"><i class="icon icon-calendar uk-margin-small-right"></i>$Start.Nice</strong><strong class="uk-margin-right"><i class="icon icon-ios-location uk-margin-small-right"></i>$City</strong>
					    	    	<% end_with %>
					    	    <% else %>
					    	    <p><i>Bisher ist kein Datum geplant</i></p>
					       		 <% end_if %>
					       	</div>
					    <div class="uk-text-muted">$Subtitle</div>
				        
					    $Description
					    <div class="uk-text-right@m">
					    	<a href="$Link" class="uk-button button-gruen" title="<%t Event.SeeDetails 'Details ansehen' %>"><%t Event.SeeDetails 'Details ansehen' %></a>
					    </div>
					   
					</div>
				</div>
			
		</div>
	</div>
	$EventStructuredData
	</section>
	<% end_loop %>
</div>
<% else %>
<section class="uk-section uk-padding-small">
	<div class="uk-container">
		<p><%t Event.NoEvents 'Keine Kurse am Moment' %></p>
	</div>
</section>
<% end_if %>
<section class="uk-section uk-padding-small">
	<div class="uk-container">
		<div class="uk-text-small">
			$Conditions
		</div>
	</div>
</section>
