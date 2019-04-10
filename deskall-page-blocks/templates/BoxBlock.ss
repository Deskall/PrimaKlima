
		<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>
		<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
			<div data-uk-height-match="target:.dk-box-content p;row:false;">
				<div class="$BoxPerLine $BoxTextAlign uk-grid-medium" data-uk-grid  <% if not FullLink %>data-uk-lightbox="toggle:.dk-lightbox" <% end_if %>data-uk-height-match="target:img;row:false;">
					<% loop ActiveBoxes %>
					
					<div class="uk-transition-toggle uk-height-1-1" tabindex="0">
						<% if Top.FullLink && LinkableLinkID > 0 && $LinkableLink.LinkURL%>
		   				<a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr}>
						<% end_if %>
						<% if Top.Layout == "inversed" %>
							<h3 class="uk-margin">$Title</h3>
							<div class="uk-margin-top dk-box-content">
						    	$Content
						   <% if LinkableLinkID > 0 %>
								<% include CallToActionLink c=r,pos=center %>
							<% end_if %>
						    </div>
						    <% if Image %>
						    	<% if $Image.getExtension == "svg" %>
						    	<div class="uk-flex uk-flex-center uk-flex-middle">
						    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)" title="$Top.TitleTag($Image.Name,$Title)"  width="$Up.PictureWidth" height="$Up.PictureHeight" />
						    	</div>
						    	<% else %>
						    	
						    		<% if not Top.FullLink %><a href="$Image.getSourceURL" class="dk-lightbox" data-caption="$Image.Description"><% end_if %>
						    			<img class="uk-width-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" dat-src="$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)" title="$Top.TitleTag($Image.Name,$Title)" data-uk-img />
							    	<% if not Top.FullLink %></a><% end_if %>
							    
						    	<% end_if %>
						    <% end_if %>
					    <% else_if Top.Layout == "mixed" %>
						     <% if Image %>
						    	<% if $Image.getExtension == "svg" %>
						    	<div class="uk-flex uk-flex-center uk-flex-middle">
						    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)" title="$Top.TitleTag($Image.Name,$Title)"  width="$Up.PictureWidth" height="$Up.PictureHeight"  />
						    	</div>
						    	<% else %>
						    	
						    		<% if not Top.FullLink %><a href="$Image.getSourceURL" class="dk-lightbox" data-caption="$Image.Description"><% end_if %>
						    			<img class="uk-width-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" data-src="$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)" title="$Top.TitleTag($Image.Name,$Title)" data-uk-img />
							    	<% if not Top.FullLink %></a><% end_if %>
							    
						    	<% end_if %>
					    	<% end_if %>
						    <h3 class="uk-margin">$Title</h3>
						    <div class="uk-margin-top dk-box-content">
						    	$Content
						    	<% if LinkableLinkID > 0 %>
									<% include CallToActionLink c=r,pos=center %>
								<% end_if %>
						    </div>
					    <% else %>
					    	<h3 class="uk-margin">$Title</h3>
						     <% if Image %>
						    	<% if $Image.getExtension == "svg" %>
						    	<div class="uk-flex uk-flex-center uk-flex-middle">
						    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)" title="$Top.TitleTag($Image.Name,$Title)"  width="$Up.PictureWidth" height="$Up.PictureHeight"  />
						    	</div>
						    	<% else %>
						    	
						    		<% if not Top.FullLink %><a href="$Image.getSourceURL" class="dk-lightbox" data-caption="$Image.Description"><% end_if %>
						    			<img class="uk-width-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" data-src="$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)" title="$Top.TitleTag($Image.Name,$Title)" data-uk-img/>
							    	<% if not Top.FullLink %></a><% end_if %>
							    
						    	<% end_if %>
						    <% end_if %>
						    <div class="uk-margin-top dk-box-content">
						    	$Content
						   <% if LinkableLinkID > 0 %>
								<% include CallToActionLink c=r,pos=center %>
							<% end_if %>
						    </div>
					    <% end_if %>
					    <% if Top.FullLink && LinkableLinkID > 0 && $LinkableLink.LinkURL%>
						</a>
						<% end_if %>
					</div>
					
					<% end_loop %>
				</div>
			</div>
		</div>