	<% if Effect == "fixed" %>
	<div class="$Height uk-background-cover uk-background-fixed uk-light <% if Background %>$Background dk-overlay <% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" <% if Image.exists %>
		data-src="$Image.ScaleWidth(1500).URL"
	    data-srcset="$Image.ScaleWidth(650).URL 650w,
	                  $Image.ScaleWidth(1200).URL 1200w,
	                  $Image.ScaleWidth(1600).URL 1600w,
	                  $Image.URL 2500w"
	    sizes="100vw" data-uk-img<% end_if %>>
	<% else %>
	<div class="$Height uk-background-cover uk-light <% if Background %>$Background dk-overlay <% end_if %><% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" 
		<% if Image.exists %>
		data-src="$Image.FocusFillMax(1600,$ImageHeight).URL"
	    data-srcset="$Image.FocusFillMax(650,$ImageHeight).URL 650w,
	                  $Image.FocusFillMax(1200,$ImageHeight).URL 1200w,
	                  $Image.FocusFillMax(1600,$ImageHeight).URL 1600w,
	                  $Image.FocusFillMax(2500,$ImageHeight).URL 2500w,
	                  $Image.FocusFillMax(5000,$ImageHeight).URL 5000w"
	    sizes="100vw"
	    data-uk-img<% end_if %>
	>
	<% end_if %>
	    <div class="uk-container uk-overflow-auto <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %>">
	    	<div class="uk-position-relative   <% if Height == "viewport" %>uk-height-viewport<% else %>$Height<% end_if %>">
			    <div class="$Layout uk-padding-small uk-padding-remove-horizontal uk-width-1-1">
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

				    <div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
					    <% if CollapseText %>
					    		<div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
					    		<div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
					    	<% else %>
					    		$HTML
					    	<% end_if %>
					</div>

				 	<% if LinkableLinkID > 0 %>
					 	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
					<% end_if %>
			    </div>
			</div>
		</div>
	</div>