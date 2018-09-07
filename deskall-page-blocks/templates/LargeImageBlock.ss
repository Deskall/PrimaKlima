<%-- <div class="uk-background-cover uk-background-norepeat $Height uk-width-1-1 <% if Background %>$Background dk-overlay <% end_if %><% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" style="background-image: url($Image.URL);" <% if Effect == "parallax" %>uk-parallax="$EffectOptions"<% end_if %> >

    <div class="uk-container uk-position-relative uk-overflow-auto <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
	    <div class="$Layout uk-padding-small">
	    	<% if $Title && $ShowTitle %>
		        <h2 class="$TitleAlign">$Title</h2>
		    <% end_if %>

		    <div class="uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			    $Content
			</div>

		 	<% if LinkableLinkID > 0 %>
			 	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
			<% end_if %>
	    </div>
	</div>
</div> --%>
	<%-- <div class="uk-cover-container uk-width-1-1 $Height <% if Height == "viewport" %>uk-height-viewport<% end_if %> <% if Background %>$Background dk-overlay <% end_if %>">
		<% if Effect == "kenburns" %><div class="uk-position-cover uk-animation-kenburns $EffectOptions"><% end_if %>
			<% if $Image.getExtension == "svg" %><img src="$Image.URL" alt="$AltTag($Image.Description,$Image.Name,$Title)" title="$TitleTag($Image.Name,$Title)" data-uk-cover /><% else %>$Image.Banners(600,450,$ImageHeight)<% end_if %>
		<% if Effect == "kenburns" %></div><% end_if %>
		<div class="uk-container uk-position-relative uk-overflow-auto <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
		    <div class="$Layout uk-padding-small">
		    	<% if $Title && $ShowTitle %>
			        <h2 class="$TitleAlign">$Title</h2>
			    <% end_if %>

			    <div class="uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				    $Content
				</div>

			 	
			 	<% if LinkableLinkID > 0 %>
			 		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
			 	<% end_if %>
		    </div>
		</div>
	</div> --%>
	<div class="$Height $Layout uk-background-cover uk-light <% if Background %>$Background dk-overlay <% end_if %><% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" 
		<% if Effect == "parallax" %>data-uk-parallax="$EffectOptions"<% end_if %>
	     data-src="$Image.ScaleWidth(350).URL"
	     data-srcset="$Image.ScaleWidth(650).URL 650w,
	                  $Image.ScaleWidth(1200).URL 1200w,
	                  $Image.ScaleWidth(1600).URL 1600w,
	                  $Image.ScaleWidth(2500).URL 2500w,
	                  $Image.ScaleWidth(5000).URL 5000w"
	     data-sizes="100vw" data-uk-img>
	    <div class="uk-container uk-overflow-auto <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
		    <div class="$Layout uk-padding-small">
		    	<% if $Title && $ShowTitle %>
			        <h2 class="$TitleAlign">$Title</h2>
			    <% end_if %>

			    <div class="uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				    $Content
				</div>

			 	<% if LinkableLinkID > 0 %>
				 	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
				<% end_if %>
		    </div>
		</div>
	</div>