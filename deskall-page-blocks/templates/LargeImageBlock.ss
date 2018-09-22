
	<div class="$Height uk-background-cover uk-light <% if Background %>$Background dk-overlay <% end_if %><% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" 
		<% if Effect == "parallax" %>data-uk-parallax="$EffectOptions"<% end_if %>
	     data-src="$Image.ScaleWidth(350).URL"
	     data-srcset="$Image.ScaleWidth(650).URL 650w,
	                  $Image.ScaleWidth(1200).URL 1200w,
	                  $Image.ScaleWidth(1600).URL 1600w,
	                  $Image.ScaleWidth(2500).URL 2500w,
	                  $Image.ScaleWidth(5000).URL 5000w"
	     data-sizes="100vw" data-uk-img>
	    <div class="uk-container uk-overflow-auto uk-position-relative <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
		    <div class="$Layout uk-padding-small">
		    	<% if isPrimary %>
		    		<h1 class="$TitleAlign">$getOwnerPage.Title</h1>
		    	<% else %>
		    		<% if Title && $ShowTitle %>
		    			<h2 class="$TitleAlign">$Title</h2>
		    		<% end_if %>
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