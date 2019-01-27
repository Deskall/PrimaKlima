
	<div class="$Height uk-background-cover uk-light <% if Background %>$Background dk-overlay <% end_if %><% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" 
		
	     data-src="$Image.ScaleWidth(350).URL"
	     data-srcset="$Image.ScaleWidth(650).URL 650w,
	                  $Image.ScaleWidth(1200).URL 1200w,
	                  $Image.ScaleWidth(1600).URL 1600w,
	                  $Image.ScaleWidth(2500).URL 2500w,
	                  $Image.ScaleWidth(5000).URL 5000w"
	     data-sizes="100vw" data-uk-img data-uk-parallax="blur: 10; sepia: 100;">
	    <div class="uk-container uk-overflow-auto <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %>">
	    	<div class="uk-position-relative  $Height">
			    <div class="$Layout uk-padding-small">
			    	<% if TitleIcon %>
					<div class="uk-flex uk-flex-middle uk-margin-bottom">
						<div class="title-icon"><i class="fa fa-{$TitleIcon}"></i></div>
						<% if isPrimary %>
				    		<h1 class="$TitleAlign">$getPage.Title</h1>
				    	<% else %>
				    		<% if Title && $ShowTitle %>
				    			<h2 class="$TitleAlign">$Title</h2>
				    		<% end_if %>
				    	<% end_if %>
					</div>
					<% else %>
				    	<% if isPrimary %>
				    		<h1 class="$TitleAlign" <% if Effect == "parallax"%>data-uk-parallax="$EffectOptions"<% end_if %>>$getPage.Title</h1>
				    	<% else %>
				    		<% if Title && $ShowTitle %>
				    			<h2 class="$TitleAlign" <% if Effect == "parallax"%>data-uk-parallax="$EffectOptions"<% end_if %>>$Title</h2>
				    		<% end_if %>
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
	</div>