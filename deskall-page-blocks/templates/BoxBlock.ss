
		<% include TextBlock %>

		<div data-uk-height-match="target:h3;row:false;" class="uk-margin">
			<div data-uk-height-match="target:.dk-box-content .box-text;">
				<div class="$BoxPerLine $BoxTextAlign" data-uk-grid  <% if not FullLink %>data-uk-lightbox="toggle:.dk-lightbox"<% end_if %> data-uk-height-match="target:img;row:false;">
					<% loop ActiveBoxes %>
					<div>
						<div class="box uk-transition-toggle uk-height-1-1" tabindex="0">
							<% if Top.FullLink && LinkableLinkID > 0 && $LinkableLink.LinkURL %>
			   				<a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr}>
							<% end_if %>
							<% if Top.Layout == "inversed" %>
								<h3 class="uk-margin">$Title</h3>
								<div class="uk-margin-top dk-box-content">
							    	<div class="box-text">$Content</div>
								   	<% if LinkableLinkID > 0 %>
										<% include CallToActionLink c=r,pos=center %>
									<% end_if %>
							    </div>
							    <% if Image %>
							    	<% include BoxImage Alt=$Top.AltTag($Image.Description, $Image.Name, $Title),Effect=Top.Effect,Width=$Up.PictureWidth,FullLink=$Top.FullLink,Height=$Up.PictureHeight %>
							    <% end_if %>
						    <% else_if Top.Layout == "mixed" %>
							    <% if Image %>
							    	<% include BoxImage Alt=$Top.AltTag($Image.Description, $Image.Name, $Title),Effect=Top.Effect,Width=$Up.PictureWidth,FullLink=$Top.FullLink,Height=$Up.PictureHeight %>
							    <% end_if %>
							    <h3 class="uk-margin">$Title</h3>
							    <div class="uk-margin-top dk-box-content">
							    	<div class="box-text">$Content</div>
							    	<% if LinkableLinkID > 0 %>
										<% include CallToActionLink c=r,pos=center %>
									<% end_if %>
							    </div>
						    <% else %>
						    	<h3 class="uk-margin">$Title</h3>
							    <% if Image %>
							    	<% include BoxImage Alt=$Top.AltTag($Image.Description, $Image.Name, $Title),Effect=Top.Effect,Width=$Up.PictureWidth,FullLink=$Top.FullLink,Height=$Up.PictureHeight %>
							    <% end_if %>
							    <div class="uk-margin-top dk-box-content">
							    	<div class="box-text">$Content</div>
								   <% if LinkableLinkID > 0 %>
										<% include CallToActionLink c=r,pos=center %>
									<% end_if %>
							    </div>
						    <% end_if %>
						    <% if Top.FullLink && LinkableLinkID > 0 && $LinkableLink.LinkURL%>
							</a>
							<% end_if %>
						</div>
					</div>
					<% end_loop %>
				</div>
			</div>
		</div>