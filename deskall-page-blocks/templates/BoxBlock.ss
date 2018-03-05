
		<div class="$TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			$HTML
		</div>
		<div class="$BoxPerLine uk-grid-match $BoxTextAlign" data-uk-grid data-uk-lightbox="toggle:.dk-lightbox" data-uk-height-match="target:h3;row:false;">
		<% loop ActiveBoxes %>
		<div class="uk-transition-toggle" tabindex="0">
			<% if Top.Layout == "inversed" %>
			<h3 class="uk-margin">$Title</h3>
			<div class="uk-margin-top dk-box-content">
		    	$Content
		    <% if $CallToActionLink.Page.Link %>
				<% include CallToActionLink c=r,pos=center %>
			<% end_if %>
		    </div>
		    <% if Image %>
		    	<% if $Top.ImageType == "icon" %>
		    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.Width" height="$Image.Height" />
		    	<% else %>
		    	<a href="$Image.getSourceURL" class="dk-lightbox"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.FocusFill(350,250).Width" height="$Image.FocusFill(350,250).Height"></a>
		    	<% end_if %>
		    <% end_if %>
		    <% else_if Top.Layout == "mixed" %>
		     <% if Image %>
		    	<% if $Top.ImageType == "icon" %>
		    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.Width" height="$Image.Height" />
		    	<% else %>
		    	<a href="$Image.getSourceURL" class="dk-lightbox"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.FocusFill(350,250).Width" height="$Image.FocusFill(350,250).Height"></a>
		    	<% end_if %>
		    <% end_if %>
		    <h3 class="uk-margin">$Title</h3>
		    <div class="uk-margin-top dk-box-content">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
					<% include CallToActionLink c=r,pos=center %>
				<% end_if %>
		    </div>
		    <% else %>
		    <h3 class="uk-margin">$Title</h3>
		     <% if Image %>
		    	<% if $Top.ImageType == "icon" %>
		    		<img class="dk-icon uk-width-auto <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.Width" height="$Image.Height" />
		    	<% else %>
		    	<a href="$Image.getSourceURL" class="dk-lightbox"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.FocusFill(350,250).Width" height="$Image.FocusFill(350,250).Height"></a>
		    	<% end_if %>
		    <% end_if %>
		    <div class="uk-margin-top dk-box-content">
		    	$Content
		    <% if $CallToActionLink.Page.Link %>
				<% include CallToActionLink c=r,pos=center %>
			<% end_if %>
		    </div>
		    <% end_if %>
		</div>
		<% end_loop %>
</div>