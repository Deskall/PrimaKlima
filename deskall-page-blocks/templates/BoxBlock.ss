
		<div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
		<% if LinkableLinkID > 0 %>
			<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		<% end_if %>
		<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
			<div data-uk-height-match="target:.dk-box-content p;row:false;">
				<div class="$BoxPerLine $BoxTextAlign uk-grid-medium" data-uk-grid data-uk-lightbox="toggle:.dk-lightbox" data-uk-height-match="target:img;row:false;">
					<% loop ActiveBoxes %>
					<div class="uk-transition-toggle uk-height-1-1" tabindex="0">
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
					    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Up.PictureWidth" height="$Up.PictureHeight" />
					    	</div>
					    	<% else %>
					    	
					    		<a href="$Image.getSourceURL" class="dk-lightbox">
					    			<img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Up.PictureWidth" height="$Up.PictureHeight" />
						    	</a>
						    
					    	<% end_if %>
					    <% end_if %>
					    <% else_if Top.Layout == "mixed" %>
					     <% if Image %>
					    	<% if $Image.getExtension == "svg" %>
					    	<div class="uk-flex uk-flex-center uk-flex-middle">
					    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Up.PictureWidth" height="$Up.PictureHeight" />
					    	</div>
					    	<% else %>
					    	
					    		<a href="$Image.getSourceURL" class="dk-lightbox">
					    			<img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Up.PictureWidth" height="$Up.PictureHeight" />
						    	</a>
						    
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
					    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Up.PictureWidth" height="$Up.PictureHeight" />
					    	</div>
					    	<% else %>
					    	
					    		<a href="$Image.getSourceURL" class="dk-lightbox">
					    			<img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill($Up.PictureWidth,$Up.PictureHeight).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Up.PictureWidth" height="$Up.PictureHeight" />
						    	</a>
						    
					    	<% end_if %>
					    <% end_if %>
					    <div class="uk-margin-top dk-box-content">
					    	$Content
					   <% if LinkableLinkID > 0 %>
							<% include CallToActionLink c=r,pos=center %>
						<% end_if %>
					    </div>
					    <% end_if %>
					</div>
					<% end_loop %>
				</div>
			</div>
		</div>